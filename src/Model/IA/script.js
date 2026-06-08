document.addEventListener('DOMContentLoaded', () => {
    const chatForm = document.getElementById('chat-form');
    const mensajeInput = document.getElementById('mensaje');
    const chatBox = document.getElementById('chat-box');
    const logo = document.getElementById('logo');

    const GROQ_API_KEY = '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';
    const URL = "https://api.groq.com/openai/v1/chat/completions";

    // CONTEXTO / SYSTEM PROMPT
    const SYSTEM_PROMPT = `
Eres un experto de compra y venta de vehiculos, tu funcion es asesorar a compradores de vehiculos de segunda mano
`;

    async function consultarIA(pregunta) {
        try {
            const respuesta = await fetch(URL, {
                method: "POST",
                headers: {
                    "Authorization": `Bearer ${GROQ_API_KEY}`,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    model: "llama-3.3-70b-versatile",
                    messages: [
                        {
                            role: "system",
                            content: SYSTEM_PROMPT
                        },
                        {
                            role: "user",
                            content: pregunta
                        }
                    ],
                    temperature: 0.7
                })
            });

            if (!respuesta.ok) return "Error al obtener respuesta.";

            const data = await respuesta.json();

            return data.choices[0].message.content;

        } catch (error) {
            return "Error de conexión.";
        }
    }

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const texto = mensajeInput.value.trim();

        if (!texto) return;

        if (logo) logo.style.display = 'none';

        mensajeInput.value = '';

        chatBox.innerHTML += `
            <div class="m-container">
                <p>${texto}</p>
            </div>
        `;

        const loadingDiv = document.createElement('div');

        loadingDiv.className = 'm-container-ia';
        loadingDiv.innerHTML = '<p>...</p>';

        chatBox.appendChild(loadingDiv);

        chatBox.scrollTop = chatBox.scrollHeight;

        const respuestaIA = await consultarIA(texto);

        loadingDiv.innerHTML = `
            <p>${respuestaIA}</p>
        `;

        chatBox.scrollTop = chatBox.scrollHeight;
    });
});


