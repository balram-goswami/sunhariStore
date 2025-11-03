<style>
/* 📱 WhatsApp-style Chatbot */
#chatbot {
    position: fixed;
    bottom: 90px;
    right: 25px;
    z-index: 9999;
    font-family: "Segoe UI", sans-serif;
}

/* Floating WhatsApp Icon */
#chat-icon {
    background: #25D366;
    color: #fff;
    width: 58px;
    height: 58px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    cursor: pointer;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
    transition: transform 0.25s, box-shadow 0.25s;
}
#chat-icon:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.5);
}

/* Chat Window */
#chat-box {
    width: 340px;
    height: 480px;
    background: #e5ddd5;
    background-size: cover;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    display: none;
    flex-direction: column;
    overflow: hidden;
    animation: popup 0.3s ease-in-out;
}
@keyframes popup {
    0% {transform: scale(0.8); opacity: 0;}
    100% {transform: scale(1); opacity: 1;}
}

/* Header */
#chat-header {
    background: #075E54;
    color: #fff;
    padding: 10px 12px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
#chat-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}
#chat-header img {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 2px solid #fff;
}
#chat-header h5 {
    margin: 0;
    font-size: 15px;
    line-height: 1.2;
}
#chat-header small {
    font-size: 12px;
    opacity: 0.8;
}
#chat-close {
    background: transparent;
    color: #fff;
    border: none;
    font-size: 20px;
    cursor: pointer;
}

/* Chat Area */
#chat-content {
    flex: 1;
    padding: 12px 10px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 8px;
    scroll-behavior: smooth;
}

/* Message bubbles */
.message {
    padding: 8px 12px;
    border-radius: 8px;
    max-width: 80%;
    position: relative;
    font-size: 14px;
    animation: fadeIn 0.25s ease-in-out;
}
@keyframes fadeIn {
    from {opacity: 0; transform: translateY(6px);}
    to {opacity: 1; transform: translateY(0);}
}
.bot {
    background: #fff;
    align-self: flex-start;
    border-radius: 8px 8px 8px 0;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}
.user {
    background: #dcf8c6;
    align-self: flex-end;
    border-radius: 8px 8px 0 8px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}
.typing {
    font-style: italic;
    color: #999;
    font-size: 13px;
}

/* Input Area */
#chat-input-area {
    background: #f0f0f0;
    padding: 8px 10px;
    display: flex;
    align-items: center;
    border-top: 1px solid #ddd;
}
#chat-input {
    flex: 1;
    border: none;
    border-radius: 20px;
    padding: 8px 12px;
    outline: none;
    font-size: 14px;
}
#chat-send {
    background: #25D366;
    color: white;
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 8px;
    cursor: pointer;
    font-size: 16px;
}

/* Scrollbar */
#chat-content::-webkit-scrollbar {
    width: 5px;
}
#chat-content::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

/* Mobile Responsiveness */
@media (max-width: 500px) {
    #chat-box {
        width: 90vw;
        height: 80vh;
        right: 5vw;
        bottom: 90px;
    }
}
</style>

<div id="chatbot">
    <div id="chat-icon"><i class="fa fa-whatsapp"></i></div>

    <div id="chat-box">
        <div id="chat-header">
            <div id="chat-header-left">
                <img src="themeAssets/images/images.jpg" alt="Assistant">
                <div>
                    <h5>Sunhari-Assistant</h5>
                    <small>Online</small>
                </div>
            </div>
            <button id="chat-close">&times;</button>
        </div>

        <div id="chat-content"></div>

        <div id="chat-input-area">
            <input type="text" id="chat-input" placeholder="Type a message..." />
            <button id="chat-send"><i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const chatIcon = document.getElementById("chat-icon");
    const chatBox = document.getElementById("chat-box");
    const chatClose = document.getElementById("chat-close");
    const chatContent = document.getElementById("chat-content");
    const chatInput = document.getElementById("chat-input");
    const chatSend = document.getElementById("chat-send");

    let step = 0;
    let chatData = {};

    // Toggle visibility
    chatIcon.onclick = () => chatBox.style.display = "flex";
    chatClose.onclick = () => chatBox.style.display = "none";

    function botMessage(text, delay = 400) {
        setTimeout(() => {
            const msg = document.createElement("div");
            msg.classList.add("message", "bot");
            msg.textContent = text;
            chatContent.appendChild(msg);
            chatContent.scrollTop = chatContent.scrollHeight;
        }, delay);
    }

    function userMessage(text) {
        const msg = document.createElement("div");
        msg.classList.add("message", "user");
        msg.textContent = text;
        chatContent.appendChild(msg);
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    function nextStep(input) {
        if (step === 0) {
            chatData.name = input;
            botMessage(`Nice to meet you, ${chatData.name}! What's your email?`);
            step++;
        } else if (step === 1) {
            chatData.email = input;
            botMessage("Got it! Please share your phone number.");
            step++;
        } else if (step === 2) {
            chatData.number = input;
            botMessage("Thanks! Please type your query below.");
            step++;
        } else if (step === 3) {
            chatData.message = input;
            botMessage("Submitting your query...");
            sendData();
            step++;
        } else {
            botMessage("✅ Thank you! Your query has been saved. We'll contact you soon.");
        }
    }

    function sendData() {
        fetch("/chatbotSave", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(chatData)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) botMessage("✅ Your query has been saved successfully!");
            else botMessage("❌ Something went wrong. Try again later.");
        })
        .catch(() => botMessage("❌ Unable to connect to the server."));
    }

    chatSend.onclick = () => {
        const input = chatInput.value.trim();
        if (!input) return;
        userMessage(input);
        chatInput.value = "";
        nextStep(input);
    };

    chatInput.addEventListener("keypress", e => {
        if (e.key === "Enter") chatSend.click();
    });

    botMessage("👋 Hello! I'm your shop assistant. What's your name?");
});
</script>
