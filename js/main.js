//back to top button hide and appear
const toTopAppear = () => {

    //fromTop fullscreen = 300
    let element = document.getElementById("backToTop");

    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        element.classList.add("show");
        console.log("appearing");
    } else {
        element.classList.remove("show");
        console.log("hidding");
    }
}
window.addEventListener("scroll", toTopAppear);


const form = document.getElementById("contactForm");
const response = document.getElementById("contactResponse");
const refresh = document.getElementById("refreshButton");
const contactSection = document.getElementById("contactForm");
const submit = document.getElementById("submit");

const submitForm = () => {
    sessionStorage.setItem("form", "submitted");
}
submit.addEventListener("click", submitForm);

const checkForm = () => {
    let check = sessionStorage.getItem("form");

    if (check == "submitted") {
        form.remove();
        //response.append();
        console.log("returned submitted");
    } else if (check == "cleared") {
        response.remove();
        contactSection.scrollIntoView();
        console.log("returned empty");
    }
}
checkForm();

const toRefresh = () => {
    sessionStorage.setItem("form", "cleared");
    location.reload();
}
refresh.addEventListener("click", toRefresh);