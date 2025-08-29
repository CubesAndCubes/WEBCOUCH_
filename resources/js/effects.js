/**
 * @param {HTMLElement} element 
 */
async function write_out(element) {
    const text = element.dataset.text;

    await new Promise((resolve, _reject) => {
        let i = 0;

        const write_interval = setInterval(() => {
            element.innerText = text.slice(0, ++i);

            if (i === text.length) {
                clearInterval(write_interval);

                resolve();
            }
        }, 125);
    });
}

async function write_out_all() {
    for (const element of document.querySelectorAll('.write-out')) {
        await write_out(element);
    }
}

write_out_all()