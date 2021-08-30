'use strict';

// Rating circle
var rating = $('#rating_circle').data('rating');
var bar = new ProgressBar.Circle(rating_circle, {
    strokeWidth: 6,
    easing: 'easeInOut',
    duration: 2000,
    color: '#4CE426',
    trailColor: '#f0f0f0',
    trailWidth: 6,
    svgStyle: null
});

bar.animate(rating);