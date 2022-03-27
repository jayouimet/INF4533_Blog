function updateProfile(event) {
    let emailInput = document.getElementById("emailInput");
    let firstNameInput = document.getElementById("firstNameInput");
    let lastNameInput = document.getElementById("lastNameInput");
    let statusMessageInput = document.getElementById("statusMessageInput");
    let updateButton = document.getElementById("updateButton");

    let params = `email=${emailInput.value}&firstname=${firstNameInput.value}&lastname=${lastNameInput.value}&status_message=${statusMessageInput.value}`;
    const xHttpObject = new XMLHttpRequest();
    xHttpObject.onload = () => {
        let obj = JSON.parse(xHttpObject.responseText);
        emailInput.disabled = false;
        firstNameInput.disabled = false;
        lastNameInput.disabled = false;
        statusMessageInput.disabled = false;
        updateButton.disabled = false;
    };
    xHttpObject.open('POST', 'update_profile', true);
    xHttpObject.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    emailInput.disabled = true;
    firstNameInput.disabled = true;
    lastNameInput.disabled = true;
    statusMessageInput.disabled = true;
    updateButton.disabled = true;

    xHttpObject.send(params);
}