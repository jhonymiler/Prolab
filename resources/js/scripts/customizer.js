/*=========================================================================================
  File Name: customizer.js
  Description: Template customizer js.
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

(function (window, document, $) {
    "use strict";

    var html = $("html"),
        body = $("body"),
        // appContent = $('.app-content'),
        mainMenu = $(".main-menu"),
        menuType = body.attr("data-menu"),
        footer = $(".footer"),
        navbar = $(".header-navbar"),
        horizontalNavbar = $(".horizontal-menu-wrapper .header-navbar"),
        navBarShadow = $(".header-navbar-shadow"),
        collapseSidebar = $("#collapse-sidebar-switch"),
        contentWrapper = $(".content-wrapper"),
        contentAreaWrapper = $(".content-area-wrapper"),
        customizer = $(".customizer"),
        thema = {},
        flag = 0;

    function setConfig(tema) {
        if (Object.keys(tema).length > 0) {
            thema["_token"] = $('meta[name="csrf-token"]').attr("content");
            $.post("/update-skin", tema);
        }
    }

    // Customizer toggle & close button click events  [Remove customizer code from production]
    $(".customizer-toggle").on("click", function (e) {
        e.preventDefault();
        $(customizer).toggleClass("open");
    });
    $(".customizer-close").on("click", function () {
        $(customizer).removeClass("open");
    });

    // perfect scrollbar for customizer
    if ($(".customizer-content").length > 0) {
        var customizer_content = new PerfectScrollbar(".customizer-content");
    }

    /***** Skin Options *****/
    $(".layout-name").on("click", function () {
        var $this = $(this);
        var currentLayout = $this.data("layout");
        html.removeClass(
            "dark-layout bordered-layout semi-dark-layout"
        ).addClass(currentLayout);

        if (currentLayout === "") {
            thema["theme"] = "light";

            mainMenu.removeClass("menu-dark").addClass("menu-light");
            navbar.removeClass("navbar-dark").addClass("navbar-light");
        } else if (currentLayout === "dark-layout") {
            thema["theme"] = "dark";

            mainMenu.removeClass("menu-light").addClass("menu-dark");
            navbar.removeClass("navbar-light").addClass("navbar-dark");
        } else if (currentLayout === "semi-dark-layout") {
            thema["theme"] = "semi-dark";

            mainMenu.removeClass("menu-light").addClass("menu-dark");
            navbar.removeClass("navbar-dark").addClass("navbar-light");
        } else if (currentLayout === "bordered-layout") {
            thema["theme"] = "bordered";

            mainMenu.removeClass("menu-dark").addClass("menu-light");
            navbar.removeClass("navbar-dark").addClass("navbar-light");
        } else {
            thema["theme"] = "light";

            mainMenu.removeClass("menu-dark").addClass("menu-light");
            navbar.removeClass("navbar-dark").addClass("navbar-light");
        }

        setConfig(thema);
    });

    // Default Skin Selected Based on Current Layout
    var layout = html.data("layout");
    $(".layout-name[data-layout='" + layout + "']").prop("checked", true);

    collapseSidebar.on("click", function () {
        $(".modern-nav-toggle").trigger("click");
        $(".main-menu").trigger("mouseleave");
        thema["sidebarCollapsed"] = $(".modern-nav-toggle").val();
        setConfig(thema);
    });

    /***** Navbar Color Options *****/
    $("#customizer-navbar-colors .color-box").on("click", function () {
        var $this = $(this);
        $this.siblings().removeClass("selected");
        $this.addClass("selected");
        var navbarColor = $this.data("navbar-color");
        // changes navbar colors
        if (navbarColor) {
            body.find(navbar)
                .removeClass(
                    "bg-primary bg-secondary bg-success bg-danger bg-info bg-warning bg-dark"
                )
                .addClass(navbarColor + " navbar-dark");
        } else {
            body.find(navbar).removeClass(
                "bg-primary bg-secondary bg-success bg-danger bg-info bg-warning bg-dark navbar-dark"
            );
        }
        if (html.hasClass("dark-layout")) {
            navbar.addClass("navbar-dark");
        }
        thema["navbarColor"] = navbarColor ? navbarColor : "";

        setConfig(thema);
    });

    /***** Navbar Type *****/
    if (body.hasClass("horizontal-menu")) {
        $(".collapse_menu").removeClass("d-none");
        $(".collapse_sidebar").addClass("d-none");

        $(".menu_type").removeClass("d-none");
        $(".navbar_type").addClass("d-none");
        // Hides hidden option in Horizontal layout
        $("#nav-type-hidden").closest("div").css("display", "none");

        $("#customizer-navbar-colors").hide();
        $(".customizer-menu")
            .attr("style", "display: none !important")
            .next("hr")
            .hide();
        $(".navbar-type-text").text("Nav Menu Types");
    }
    // Hides Navbar
    $("#nav-type-hidden").on("click", function () {
        navbar.addClass("d-none");
        navBarShadow.addClass("d-none");
        body.removeClass(
            "navbar-static navbar-floating navbar-sticky"
        ).addClass("navbar-hidden");

        thema["verticalMenuNavbarType"] = "hidden";
        setConfig(thema);
    });
    // changes to Static navbar
    $("#nav-type-static").on("click", function () {
        if (body.hasClass("horizontal-layout")) {
            horizontalNavbar.removeClass(
                "d-none floating-nav fixed-top navbar-fixed container-xxl"
            );
            body.removeClass(
                "navbar-hidden navbar-floating navbar-sticky"
            ).addClass("navbar-static");
        } else {
            navBarShadow.addClass("d-none");
            if (menuType === "horizontal-menu") {
                horizontalNavbar
                    .removeClass("d-none floating-nav fixed-top container-xxl")
                    .addClass("navbar-static-top");
            } else {
                navbar
                    .removeClass("d-none floating-nav fixed-top container-xxl")
                    .addClass("navbar-static-top");
            }
            body.removeClass(
                "navbar-hidden navbar-floating navbar-sticky"
            ).addClass("navbar-static");
        }
        thema["verticalMenuNavbarType"] = "static";
        setConfig(thema);
    });
    // change to floating navbar
    $("#nav-type-floating").on("click", function () {
        var $class;
        if (body.hasClass("horizontal-layout")) {
            if ($("#layout-width-full").prop("checked")) {
                $class = "floating-nav";
            } else {
                $class = "floating-nav container-xxl";
            }
            horizontalNavbar
                .removeClass("d-none fixed-top navbar-static-top")
                .addClass($class);
            body.removeClass(
                "navbar-static navbar-hidden navbar-sticky"
            ).addClass("navbar-floating");
        } else {
            if ($("#layout-width-full").prop("checked")) {
                $class = "floating-nav";
            } else {
                $class = "floating-nav container-xxl p-0";
            }
            navBarShadow.removeClass("d-none");
            if (menuType === "horizontal-menu") {
                horizontalNavbar
                    .removeClass("d-none navbar-static-top fixed-top")
                    .addClass($class);
            } else {
                navbar
                    .removeClass("d-none navbar-static-top fixed-top")
                    .addClass($class);
            }
            body.removeClass(
                "navbar-static navbar-hidden navbar-sticky"
            ).addClass("navbar-floating");
        }
        thema["verticalMenuNavbarType"] = "floating";
        setConfig(thema);
    });
    // changes to Static navbar
    $("#nav-type-sticky").on("click", function () {
        if (body.hasClass("horizontal-layout")) {
            horizontalNavbar
                .removeClass(
                    "d-none floating-nav navbar-static-top navbar-fixed container-xxl"
                )
                .addClass("fixed-top");
            body.removeClass(
                "navbar-static navbar-floating navbar-hidden"
            ).addClass("navbar-sticky");
        } else {
            navBarShadow.addClass("d-none");
            if (menuType === "horizontal-menu") {
                horizontalNavbar
                    .removeClass("d-none floating-nav navbar-static-top")
                    .addClass("fixed-top");
            } else {
                navbar
                    .removeClass(
                        "d-none floating-nav navbar-static-top container-xxl"
                    )
                    .addClass("fixed-top");
            }

            body.removeClass(
                "navbar-static navbar-floating navbar-hidden"
            ).addClass("navbar-sticky");
        }
        thema["verticalMenuNavbarType"] = "sticky";
        setConfig(thema);
    });

    /***** Layout Width Options *****/
    // Check current Layout width and show selected layout width accordingly
    if (
        contentWrapper.hasClass("container-xxl") ||
        contentAreaWrapper.hasClass("container-xxl")
    ) {
        $("#layout-width-boxed").prop("checked", true);
    } else {
        $("#layout-width-full").prop("checked", true);
    }

    // Full Width Layout
    $("#layout-width-full").on("click", function () {
        contentWrapper.removeClass("container-xxl p-0");
        contentAreaWrapper.removeClass("container-xxl p-0");
        navbar.removeClass("container-xxl p-0");

        thema["layoutWidth"] = "full";
        setConfig(thema);
    });
    // Boxed Layout
    $("#layout-width-boxed").on("click", function () {
        contentWrapper.addClass("container-xxl p-0");
        contentAreaWrapper.addClass("container-xxl p-0");
        if (navbar.hasClass("floating-nav")) {
            $(".floating-nav").addClass("container-xxl p-0");
        }
        thema["layoutWidth"] = "boxed";
        setConfig(thema);
    });

    /***** Footer Type *****/
    // Hides footer
    $("#footer-type-hidden").on("click", function () {
        footer.addClass("d-none");
        body.removeClass("footer-static footer-fixed").addClass(
            "footer-hidden"
        );
        thema["footerType"] = "hidden";
        setConfig(thema);
    });
    // changes to Static footer
    $("#footer-type-static").on("click", function () {
        body.removeClass("footer-fixed");
        footer.removeClass("d-none").addClass("footer-static");
        body.removeClass("footer-hidden footer-fixed").addClass(
            "footer-static"
        );
        thema["footerType"] = "static";
        setConfig(thema);
    });
    // changes to Sticky footer
    $("#footer-type-sticky").on("click", function () {
        body.removeClass("footer-static footer-hidden").addClass(
            "footer-fixed"
        );
        footer.removeClass("d-none footer-static");
        thema["footerType"] = "sticky";
        setConfig(thema);
    });

    // checks if main menu is collapsed by default
    if (body.hasClass("menu-collapsed")) {
        collapseSidebar.prop("checked", true);
    } else {
        collapseSidebar.prop("checked", false);
    }
})(window, document, jQuery);
