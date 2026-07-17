//---------------Header sroll---------------
$(function () {
    $(window).on("scroll", function () {
        if ($(window).scrollTop() > 5) {
            $("#header").addClass("h-active");
        } else {
            $("#header").removeClass("h-active");
        }
    });
});

// Scroll Top
$(function () {
    $(window).on("scroll", function () {
        if ($(window).scrollTop() > 220) {
            $("#top").css("opacity", "0");
        } else {
            $("#top").css("opacity", "1");
        }
    });
});

$("form").on("change", ".file-upload-field", function () {
    $(this)
        .parent(".file-upload-wrapper")
        .attr(
            "data-text",
            $(this)
                .val()
                .replace(/.*(\/|\\)/, "")
        );
});

document.addEventListener("click", function (e) {
    // Hamburger menu
    if (e.target.classList.contains("hamburger-toggle")) {
        e.target.children[0].classList.toggle("active");
    }
});
