var bigBonfireText = document.querySelector('#bigBonfire');
var bonfireletters = bigBonfireText.querySelectorAll('.bonFireLetters');

let isAnimating = [];
const textColor = '#eee6f3';
const secondaryColor = '#3a134e';
const animationDuration = 400;
const animationEasing = 'cubicBezier(.49,-0.03,.65,1.4)';

bonfireletters.forEach((letter, i) => {
  letter.addEventListener('mouseenter', () => {
    animateText(letter, i);
  });
});

function animateText(letter, i) {
  if (isAnimating[i]) { return; }

  isAnimating[i] = true;
  anime({
    targets: letter,
    translateY: [
      { value: '-10%' },
      { value: '0%' }
    ],

    color: [
      { value: [textColor, secondaryColor] },
      { value: [secondaryColor, textColor] } 
    ],

    duration: animationDuration,
    easing: animationEasing,

    complete: function() {
      isAnimating[i] = false;
    }
  });
}
