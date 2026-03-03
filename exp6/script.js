document.getElementById("userForm").addEventListener("submit", function(event) {

    event.preventDefault();   // Stop page refresh

    var name = document.getElementById("name").value;
    var phone = document.getElementById("phone").value;
    var email = document.getElementById("email").value;
    var skills = document.getElementById("skills").value;
    var hobbies = document.getElementById("hobbies").value;
    var message = document.getElementById("message").value;

    var outputData =
        "Name: " + name + "\n" +
        "Phone: " + phone + "\n" +
        "Email: " + email + "\n" +
        "Skills: " + skills + "\n" +
        "Hobbies: " + hobbies + "\n" +
        "Message: " + message;

    document.getElementById("outputContent").innerText = outputData;

    document.getElementById("outputBox").classList.remove("hidden");
});

function copyData() {

    var content = document.getElementById("outputContent").innerText;

    navigator.clipboard.writeText(content)
        .then(function() {
            alert("Data copied successfully!");
        })
        .catch(function() {
            alert("Copy failed!");
        });
}

function resetForm() {

    // Clear form fields
    document.getElementById("userForm").reset();

    // Hide output box
    document.getElementById("outputBox").classList.add("hidden");

    // Clear displayed data
    document.getElementById("outputContent").innerText = "";
}