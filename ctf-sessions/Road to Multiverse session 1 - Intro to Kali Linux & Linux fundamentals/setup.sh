#!/bin/bash
# Minimal BOTM flag demo (instructor-side)
# Put this file in /root and run as root
USER_HOME="/home/cybergryffin"

# clean previous artifacts (if any)
rm -f "$USER_HOME/flag1.txt" "$USER_HOME/story.txt"
sed -i '/# BOTM{/d' /etc/passwd 2>/dev/null

# FLAG 1: visible in home when user runs ls
cat > "$USER_HOME/flag1.txt" <<'EOF'
Welcome to the Linux Fundamentals Challenge!
BOTM{welcome_to_linux_basics}
EOF

# -------------------------
# FLAG 4: long story (10-20 paragraphs) with a hidden flag embedded deep inside one paragraph
# -------------------------
USER_HOME="/home/cybergryffin"
OUT="$USER_HOME/story.txt"

# number of paragraphs to generate (choose between 10 and 20)
PARA_COUNT=$((10 + RANDOM % 11))   # gives 10..20

# seed paragraphs (fsociety-style/fake story lines). We'll reuse and vary them.
seed_paras=(
"Fsociety was an idea that started in basements, fueled by coffee and stubborn curiosity."
"The group spoke in hushed tones about privacy, freedom of information and rewriting the rules."
"Old-school hackers, new scripting tricks, and midnight meetings around flickering monitors."
"A manifesto printed on a single sheet, folded many times, carried in a jacket pocket."
"They believed that a single well-placed exploit could reveal systemic rot and force change."
"Sometimes they left breadcrumbs: harmless scripts, README files, or a curious filename."
"Not all of their operations were dramatic — many were meticulous cleanup and data hygiene."
"Stories of broken corporate firewalls made their way into chatrooms and late-night code reviews."
"A fake company, a fake login page — the lesson was always to question the obvious."
"Comms were via throwaway channels and encrypted messages; trust was scarce and precious."
"Some members were poets; they preferred metaphors and encrypted sonnets to dry technical notes."
"At times the group created artful logs and deceptively mundane text files as lessons."
"New recruits were given puzzles and asked to find small, hidden tokens in large files."
"Workshops were held to teach grep, find, sed and awk — the tools of quiet discovery."
"They documented mistakes openly so other teams could learn without repeating them."
"One rule stood above the rest: curiosity must be guided by caution and respect for privacy."
"Members would often practice by hiding small messages in long, otherwise boring files."
"The philosophy was practical: make learning repeated, slightly obfuscated, and resilient."
"Sometimes the puzzles were tedious on purpose — to teach attention to detail and persistence."
"Every exercise ended with a debrief: what did we learn, what did we fix, and what remains?"
)

# build the paragraphs file, choosing random seeded paragraphs to get to PARA_COUNT
> "$OUT"
for i in $(seq 1 $PARA_COUNT); do
  # pick a seed paragraph (repeat allowed) and slightly vary it
  p="${seed_paras[RANDOM % ${#seed_paras[@]}]}"
  # optionally append a small suffix to make paragraphs vary
  suffixes=(" " " The text continues in quiet detail." " This line conceals more than it reveals." " Read slowly, attentively, and repeatedly." "")
  p="$p${suffixes[RANDOM % ${#suffixes[@]}]}"
  echo "$p" >> "$OUT"
  echo "" >> "$OUT"
done

# choose a random paragraph index to hide the flag in (1-based)
target=$((1 + RANDOM % PARA_COUNT))

# read the file into an array of paragraphs (preserving blank line separators)
# we'll reconstruct with the flag embedded in the target paragraph
mapfile -t all_lines < "$OUT"
# combine lines into paragraphs (split on blank lines)
paras=()
curr=""
for line in "${all_lines[@]}"; do
  if [[ -z "$line" ]]; then
    if [[ -n "$curr" ]]; then
      paras+=("$curr")
      curr=""
    fi
  else
    if [[ -z "$curr" ]]; then
      curr="$line"
    else
      curr="$curr $line"
    fi
  fi
done
# add last if present
if [[ -n "$curr" ]]; then
  paras+=("$curr")
fi

# ensure we have the expected number
# if not, fall back to seed-paragraphs joining
if [[ ${#paras[@]} -lt $PARA_COUNT ]]; then
  paras=()
  for i in $(seq 1 $PARA_COUNT); do
    paras+=("${seed_paras[RANDOM % ${#seed_paras[@]}]}")
  done
fi

# the flag to embed
FLAG_TEXT="BOTM{grep_and_find_skillz}"

# embed the flag into the chosen paragraph at a random word boundary
idx=$((target-1))
orig="${paras[$idx]}"
# split into words
read -a words <<< "$orig"
wcount=${#words[@]}
# choose insertion position between words (0..wcount)
pos=$((RANDOM % (wcount + 1)))
newpara=""
for ((i=0;i<=wcount;i++)); do
  if [[ $i -eq $pos ]]; then
    # insert the flag in a sentence-like way (not on its own line)
    newpara="$newpara $FLAG_TEXT"
  fi
  if [[ $i -lt $wcount ]]; then
    newpara="$newpara ${words[$i]}"
  fi
done
# normalize whitespace
newpara="$(echo "$newpara" | sed -E 's/^[[:space:]]+//; s/[[:space:]]{2,}/ /g')"

# replace paragraph
paras[$idx]="$newpara"

# write back to story.txt with blank lines between paragraphs
: > "$OUT"
for p in "${paras[@]}"; do
  echo "$p" >> "$OUT"
  echo "" >> "$OUT"
done

# FLAG 5: append final flag to /etc/passwd (comment line)
echo "# BOTM{system_user_understanding}" >> /etc/passwd

# Watch for directory creation in user's home and drop FLAG 2 + FLAG 3
inotifywait -m -e create --format '%w%f' "$USER_HOME" | while read NEWPATH; do
  if [ -d "$NEWPATH" ]; then
    # FLAG 2 (file)
    echo "BOTM{mkdir_mastery}" > "$NEWPATH/flag2.txt"
    # FLAG 3 (hidden text file)
    echo "BOTM{hidden_files_revealed}" > "$NEWPATH/.flag3.txt"
  fi
done
