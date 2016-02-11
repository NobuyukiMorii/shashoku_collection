(function (window, document) {

    var layout   = document.getElementById('layout'),
        menu     = document.getElementById('menu'),
        menuLink = document.getElementById('menuLink'),
        mask     = document.getElementById('mask');

    mask.style.width = screen.width + "px";
    mask.style.height = screen.height + "px";

    function toggleClass(element, className) {
        var classes = element.className.split(/\s+/),
            length = classes.length,
            i = 0;

        for(; i < length; i++) {
            if (classes[i] === className) {
                classes.splice(i, 1);
                // if (className=="is-hidden") {
                //     $(window).on('touchmove.noScroll', function(e) {
                //     e.preventDefault();
                // });
                // }
                break;
            }
        }
        // The className is not found
        if (length === classes.length) {
            classes.push(className);
            // if (className=="is-hidden") {
            //     $(window).off('.noScroll');
            // });
        }
        element.className = classes.join(' ');
    }
    function menuSwitch(e) {
        var active = 'active';
        e.preventDefault();
        toggleClass(layout, active);
        toggleClass(menu, active);
        toggleClass(menuLink, active);
        toggleClass(mask, "is-hidden");
    }
    menuLink.onclick = function (e) {
        menuSwitch(e);
    }
    mask.onclick = function (e) {
        menuSwitch(e);
    }

}(this, this.document));
