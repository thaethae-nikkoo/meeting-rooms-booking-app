document.getElementById("year").innerHTML = new Date().getFullYear();

const passField = document.getElementById("password");
const showBtn = document.querySelector(".show-btn i");
showBtn.onclick = () => {
    if (passField.type === "password") {
        passField.type = "text";
        showBtn.classList.add("hide-btn");
    } else {
        passField.type = "password";
        showBtn.classList.remove("hide-btn");
    }
};

