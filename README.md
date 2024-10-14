# Messenger App

Inertia, react, reverb

## Broadcasting

```bash
    php artisan install:broadcasting

    # yes for reverb
    # yes for node dependencies


    # Env file content for ws
    BROADCAST_CONNECTION=reverb
    REVERB_APP_ID=
    REVERB_APP_KEY=
    REVERB_APP_SECRET=
    REVERB_HOST="localhost"
    REVERB_PORT=8080
    REVERB_SCHEME=http

    VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
    VITE_REVERB_HOST="${REVERB_HOST}"
    VITE_REVERB_PORT="${REVERB_PORT}"
    VITE_REVERB_SCHEME="${REVERB_SCHEME}"

```

## Packages

[Headlessui](https://headlessui.com/)

[Heroicons](https://heroicons.com/)

[Daisyui](https://daisyui.com/)

[EmojiPickerREact](https://www.npmjs.com/package/emoji-picker-react)

[ReactMarkdown](https://www.npmjs.com/package/react-markdown)

[UUID](https://www.npmjs.com/package/uuid)

## Start Developing

```bash
 ./start-dev.sh # start tmux server with laravel server, reverb server, vite bundler and queue work

#  close the tmux session with :
tmux kill-session -t lara
```
