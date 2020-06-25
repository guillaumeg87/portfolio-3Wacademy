/**
 * Pagination
 *
 * Handle pagination link for responsive behavior
 *
 * @namespace Pagination
 */
const Pagination = {

    init: function () {

        (function () {
            let paginationBlock = document.getElementsByClassName('pagination__btn_link');
            window.onresize = displayWindowSize;
            window.onload = displayWindowSize;

            function displayWindowSize() {
                let myWidth;

                myWidth = window.innerWidth;

                let buttons = document.getElementsByClassName('pagination__btn_link');
                let wrapper1 = document.querySelector('.pagination__link_wrapper1');
                let wrapper2 = document.querySelector('.pagination__link_wrapper2');

                if (myWidth < 1024 && myWidth > 780) {

                    for (let i = 0; i < buttons.length; i++) {

                        if (buttons[i].classList.contains('last') || buttons[i].classList.contains('first')) {

                            if  (wrapper1.children.length !== 0){
                                wrapper1.appendChild(buttons[i]);
                            }
                        }
                    }
                }
                else if (paginationBlock.length > 2 && myWidth < 780 && myWidth > 560) {

                    for (let i = 0; i < buttons.length; i++) {

                        if (buttons[i].classList.contains('last') || buttons[i].classList.contains('first')) {

                            if  (wrapper2.children.length < 3){
                                wrapper2.appendChild(buttons[i]);
                            }
                        }
                    }
                }
            }
        })();
    },
};

export { Pagination };

/**
 * Run init function of app
 * when the document is ready
 */
$(document).ready(function () {

    Pagination.init();

});
