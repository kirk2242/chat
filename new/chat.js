document.addEventListener("DOMContentLoaded", function () {
    let sendBtn = document.getElementById("send-btn");
    let messageInput = document.getElementById("message-input");
    let roomIdInput = document.getElementById("room-id");
    let chatBox = document.getElementById("chat-box");

    if (!sendBtn || !messageInput || !roomIdInput) {
        console.error("Error: Required elements are missing in the HTML.");
        return;
    }

    sendBtn.addEventListener("click", function () {
        let message = messageInput.value;
        let roomId = roomIdInput.value;

        if (message.trim() === "") return;

        fetch("send_message.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "message=" + encodeURIComponent(message) + "&room_id=" + encodeURIComponent(roomId)
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                messageInput.value = "";
                loadMessages();
            } else {
                alert(data);
            }
        })
        .catch(error => console.error("Fetch Error:", error));
    });

    function loadMessages() {
        fetch("get_messages.php")
        .then(response => response.json())
        .then(messages => {
            chatBox.innerHTML = messages.map(m => {
                let messageClass = (m.username === currentUser) ? "sent" : "received"; // Align sender right, receiver left
                return `<div class="message ${messageClass}">
                            <strong>${m.username}:</strong> ${m.message}
                        </div>`;
            }).join("");

            // Auto-scroll to the latest message
            chatBox.scrollTop = chatBox.scrollHeight;
        });
    }

    // Simulating the current user (change this to get the actual logged-in user)
    let currentUser = "You"; // Replace this with the actual logged-in username

    setInterval(loadMessages, 3000);
});
