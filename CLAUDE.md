@AGENTS.md

## Claude Code specifics

- Prefer the Grep and Glob tools scoped to a path over broad searches. Use `files_with_matches` mode before `content` mode.
- Use Read with `offset`/`limit` for large files. Do not re-read a file after editing it.
- Do not spawn subagents unless asked. Handle searches inline.
- Pipe long Bash output through `head`/`tail`, or filter it to the relevant lines.
- Answer the user in Polish. Keep code, comments, and commit messages in English.
