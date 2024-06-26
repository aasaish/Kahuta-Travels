// Example data (replace with your actual data fetching logic)
const members = [
    { name: "AASAISH ALI", regNo: "BSE-213206" },
    { name: "AMAZ MUHAAMMAD", regNo: "BSE-213006" }
];

// Function to populate member data
function populateMembers() {
    const container = document.getElementById("members-container");

    // Clear previous content
    container.innerHTML = "";

    // Iterate through each member and create HTML elements
    members.forEach(member => {
        const memberDiv = document.createElement("div");
        memberDiv.classList.add("member");

        const memberName = document.createElement("h2");
        memberName.textContent = member.name;

        const regNoPara = document.createElement("p");
        regNoPara.innerHTML = `<strong>Registration No:</strong> ${member.regNo}`;

        memberDiv.appendChild(memberName);
        memberDiv.appendChild(regNoPara);

        container.appendChild(memberDiv);
    });
}

// Call the function to populate members on page load
document.addEventListener("DOMContentLoaded", () => {
    populateMembers();
});
