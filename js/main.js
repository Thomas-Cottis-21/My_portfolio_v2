//back to top button

window.onscroll = function() {toTopAppear()};

const toTopAppear = () => {
    let element = document.getElementById("backToTop");
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        element.classList.add("show");
    } else {
        element.classList.remove("show");
    }
}