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
