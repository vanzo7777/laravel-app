import './bootstrap';
import './search-live';
import '../scss/app.scss';


document.addEventListener("DOMContentLoaded", function() {

    const faqItems = document.querySelectorAll('.faq__item');

    faqItems.forEach((item) => {
        const button = item.querySelector('.faq__question');
        const answerWrap = item.querySelector('.faq__answer-wrap');
        const answer = item.querySelector('.faq__answer');

        if(!button || !answerWrap || !answer) return;

        const firstItem = faqItems[0];
        const firstWrap = firstItem.querySelector('.faq__answer-wrap');
        const firstAnswer = firstItem.querySelector('.faq__answer');
    
        if (firstItem && firstWrap && firstAnswer) {
            firstItem.classList.add('is-active');
            firstWrap.style.height = `${firstAnswer.scrollHeight}px`;
        }

        button.addEventListener('click', function() {
            const isActive = item.classList.contains('is-active');

            faqItems.forEach((faqItem) => {
                faqItem.classList.remove('is-active');
                const wrap = faqItem.querySelector('.faq__answer-wrap');
                if(wrap) {
                    wrap.style.height = '0px';
                }
            });

            if(!isActive) {
                item.classList.add('is-active');
                answerWrap.style.height = `${answer.scrollHeight + 20}px`;
            }
        })
    });


    window.addEventListener('resize', () => {
        const activeItem = document.querySelector('.faq__item.is-active');
        if(!activeItem) return;

        const activeWrap = activeItem.querySelector('.faq__answer-wrap');
        const activeAnswer = activeItem.querySelector('.faq__answer');

        if(activeWrap && activeAnswer) {
            activeWrap.style.height = `${activeAnswer.scrollHeight + 20}px`;
        }
    })

    function equalHeights(selector) {
        let maxHeight = 0;
        let items = document.querySelectorAll(selector);

        if(items.length > 0) {
            for (let i = 0; i < items.length; i++) {
                if(items[i].offsetHeight > maxHeight ) {
                    maxHeight = items[i].offsetHeight;
                }
            }

            items.forEach(element => {
                element.style.height = maxHeight + 'px';
            });
        }
    }

    equalHeights('.card__item .card__title');
    equalHeights('.card__item .card__excerpt');

});