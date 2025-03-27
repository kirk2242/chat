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
        const roomId = document.getElementById("room-id").value;
        fetch("get_messages.php?room_id=" + encodeURIComponent(roomId))
        .then(response => response.json())
        .then(messages => {
            let chatBox = document.getElementById("chat-box");
            chatBox.innerHTML = "";
    
            messages.forEach(msg => {
                let messageDiv = document.createElement("div");
                let usernameSpan = document.createElement("span");
                let timestampSpan = document.createElement("span");
                let deleteBtn = document.createElement("button");
    
                if (msg.user_id == currentUserId) {
                    messageDiv.classList.add("sent"); // Sender's message (aligned to the right)
                } else {
                    messageDiv.classList.add("received"); // Receiver's message (aligned to the left)
                }
    
                usernameSpan.textContent = msg.username + ": "; // Add username
                usernameSpan.style.fontWeight = "bold"; // Style the username
                messageDiv.appendChild(usernameSpan);
    
                messageDiv.appendChild(document.createTextNode(msg.message));

                // Add timestamp at the bottom
                timestampSpan.textContent = msg.timestamp;
                timestampSpan.classList.add("timestamp");
                messageDiv.appendChild(timestampSpan);

                // Add delete button for each message
                deleteBtn.textContent = "Delete";
                deleteBtn.style.marginLeft = "10px";
                deleteBtn.style.cursor = "pointer";
                deleteBtn.addEventListener("click", function () {
                    deleteMessage(msg.id);
                });
                messageDiv.appendChild(deleteBtn);

                chatBox.appendChild(messageDiv);
            });
    
            chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to latest message
        })
        .catch(error => console.error("Error loading messages:", error));
    }

    function deleteMessage(messageId) {
        fetch("delete_message.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "message_id=" + encodeURIComponent(messageId)
        })
        .then(response => response.text())
        .then(data => {
            if (data.trim() === "success") {
                loadMessages();
            } else {
                alert(data);
            }
        })
        .catch(error => console.error("Error deleting message:", error));
    }

    document.getElementById("clear-all-btn").addEventListener("click", function () {
        if (confirm("Are you sure you want to clear all messages?")) {
            fetch("clear_messages.php", { method: "POST" })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === "success") {
                    loadMessages();
                } else {
                    alert(data);
                }
            })
            .catch(error => console.error("Error clearing messages:", error));
        }
    });
    
    setInterval(loadMessages, 3000);
});

document.getElementById("logout-btn").addEventListener("click", function () {
    window.location.href = "logout.php"; // Redirect to logout script
});



