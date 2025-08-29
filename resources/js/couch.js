import axios from "axios";

const room_meta = document.getElementById('room-meta');

function couch_channel() {
    /**
     * @type {HTMLVideoElement}
     */
    const couch_media = document.getElementById('couch-media');

    const uuid = room_meta.dataset.uuid;

    const username = room_meta.dataset.username;
    
    if (room_meta.dataset.seek) {
        couch_media.currentTime = room_meta.dataset.seek;
    }

    const couch_chat_log = document.getElementById('couch-chat-log');

    /**
     * @type {HTMLInputElement}
     */
    const couch_chat_input = document.getElementById('couch-chat-input');

    /**
     * @type {HTMLButtonElement}
     */
    const couch_chat_submit = document.getElementById('couch-chat-submit');

    const channel = Echo.private(`room.${uuid}`);

    let prevent_event = false;

    channel.listen('.media.change', (event) => {
        prevent_event = true;

        console.log('Media changed:', event);

        couch_media.src = event.src;

        couch_media.currentTime = 0.0;

        couch_media.removeAttribute('autoplay');

        setTimeout(() => {
            prevent_event = false;
        }, 1);
    });

    channel.listenForWhisper('play', (event) => {
        prevent_event = true;

        console.log('Media played:', event);

        couch_media.currentTime = Number(event.seek);

        couch_media.play();

        setTimeout(() => {
            prevent_event = false;
        }, 1);
    });

    channel.listenForWhisper('pause', (event) => {
        prevent_event = true;

        console.log('Media paused:', event);

        couch_media.currentTime = Number(event.seek);

        couch_media.pause();

        setTimeout(() => {
            prevent_event = false;
        }, 1);
    });

    const add_chat_message = (username, message) => {
        const message_element = document.createElement('p');

        message_element.classList.add('couch-chat-message');

        const username_element = document.createElement('span');

        username_element.classList.add('couch-chat-username');

        username_element.innerText = username;

        const text_element = document.createElement('span');

        text_element.classList.add('couch-chat-text');

        text_element.innerText = message;

        message_element.append(username_element, text_element);

        couch_chat_log.append(message_element);
    };

    channel.listenForWhisper('chat', (event) => {
        console.log('Received chat message:', event);

        add_chat_message(event.username, event.message);
    });

    couch_media.addEventListener('play', async event => {
        if (prevent_event) {
            event.preventDefault();

            return;
        }

        console.log('Play media.');

        channel.whisper('play', {
            seek: couch_media.currentTime,
        });

        axios.post(`/couches/${uuid}/play`, {
            seek: couch_media.currentTime,
        });
    });

    couch_media.addEventListener('pause', async event => {
        if (prevent_event) {
            event.preventDefault();

            return;
        }

        console.log('Pause media.');

        channel.whisper('pause', {
            seek: couch_media.currentTime,
        });

        axios.post(`/couches/${uuid}/pause`, {
            seek: couch_media.currentTime,
        });
    });

    const send_chat_message = () => {
        const message = couch_chat_input.value;

        if (1 > message.trim().length) {
            return;
        }

        console.log('Send chat message:', message);

        add_chat_message(username, message);

        channel.whisper('chat', {
            username: username,
            message: message,
        });

        couch_chat_input.value = '';
    };

    couch_chat_input.addEventListener('keydown', event => {
        if (event.code === 'Enter') {
            send_chat_message();
        }
    });

    couch_chat_submit.addEventListener('click', send_chat_message);
}

if (app.dataset.name === 'view-couch') {
    couch_channel();
}