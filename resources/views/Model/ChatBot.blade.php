<style>
#chatbot { position: fixed; bottom: 100px; right: 25px; z-index: 9999; }
#chat-icon { background: #25D366; color: #fff; width: 50px; height: 50px; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 28px; cursor: pointer; box-shadow: 0 4px 10px rgba(0,0,0,0.3); transition: transform 0.3s; }
#chat-icon:hover { transform: scale(1.1); }
#chat-box { width: 320px; height: 440px; background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); display: none; flex-direction: column; overflow: hidden; }
#chat-header { background: #25D366; color: #fff; padding: 12px 15px; display: flex; justify-content: space-between; align-items: center; }
#chat-content { flex: 1; padding: 15px; overflow-y: auto; font-size: 14px; }
.message { margin-bottom: 10px; padding: 8px 12px; border-radius: 10px; max-width: 80%; display: inline-block; clear: both; }
.bot { background: #f1f0f0; float: left; }
.user { background: #25D366; color: #fff; float: right; }
.typing { font-style: italic; color: #888; font-size: 13px; }
#chat-input-area { display: flex; padding: 10px; border-top: 1px solid #eee; }
#chat-input { flex: 1; padding: 8px; border-radius: 8px; border: 1px solid #ddd; }
#chat-send { background: #25D366; color: #fff; border: none; border-radius: 8px; padding: 0 12px; margin-left: 6px; cursor: pointer; }
</style>

<div id="chatbot">
    <div id="chat-icon"><i class="fa fa-comments"></i></div>
    <div id="chat-box">
        <div id="chat-header">
            <h5>💬 Customer Assistant</h5>
            <button id="chat-close">&times;</button>
        </div>
        <div id="chat-content"></div>
        <div id="chat-input-area">
            <input type="text" id="chat-input" placeholder="Type your reply..." />
            <button id="chat-send"><i class="fa fa-paper-plane"></i></button>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

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

    chatIcon.onclick = () => chatBox.style.display = "flex";
    chatClose.onclick = () => chatBox.style.display = "none";

    function botMessage(text, delay=200){
        setTimeout(() => {
            const msg = document.createElement("div");
            msg.classList.add("message","bot");
            msg.textContent = text;
            chatContent.appendChild(msg);
            chatContent.scrollTop = chatContent.scrollHeight;
        }, delay);
    }

    function userMessage(text){
        const msg = document.createElement("div");
        msg.classList.add("message","user");
        msg.textContent = text;
        chatContent.appendChild(msg);
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    function nextStep(input){
        if(step===0){
            chatData.name = input;
            botMessage(`Nice to meet you, ${chatData.name}! What's your email?`);
            step++;
        } else if(step===1){
            chatData.email = input;
            botMessage("Got it! Please share your phone number.");
            step++;
        } else if(step===2){
            chatData.number = input;
            botMessage("Thanks! Please type your query below.");
            step++;
        } else if(step===3){
            chatData.message = input;
            botMessage("Submitting your query...");
            sendData();
            step++;
        } else {
            botMessage("Thank you! Your query has been saved. 🙏");
        }
    }

    function sendData(){
        fetch("/chatbot/store", {
            method: "POST",
            headers: {
                "Content-Type":"application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(chatData)
        })
        .then(res=>res.json())
        .then(data=>{
            if(data.success){
                botMessage("✅ Your query has been saved successfully!");
            } else {
                botMessage("❌ Something went wrong. Try again later.");
            }
        })
        .catch(()=>botMessage("❌ Unable to connect to the server."));
    }

    chatSend.onclick = () => {
        const input = chatInput.value.trim();
        if(!input) return;
        userMessage(input);
        chatInput.value = "";
        nextStep(input);
    };

    chatInput.addEventListener("keypress", e => {
        if(e.key === "Enter") chatSend.click();
    });

    botMessage("Hello 👋 I'm your shopping assistant. What's your name?");
});
</script>
