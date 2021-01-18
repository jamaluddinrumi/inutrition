function onLoginSubmit() {
    const loginButton = document.getElementById("login-button");
    const spinningIcon = `<span class="v-btn__loader"><div role="progressbar" aria-valuemin="0" aria-valuemax="100" class="v-progress-circular v-progress-circular--indeterminate" style="height: 23px; width: 23px;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="21.904761904761905 21.904761904761905 43.80952380952381 43.80952380952381" style="transform: rotate(0deg);"><circle fill="transparent" cx="43.8095238095238
    1" cy="43.80952380952381" r="20" stroke-width="10" stroke-dasharray="125.664" stroke-dashoffset="125.66370614359172px" class="v-progress-circular__overlay"></circle></svg><div class="v-progress-circular__info"></div></div></span>`;

    loginButton.classList.add("v-btn--loading");
    loginButton.insertAdjacentHTML("beforeend", spinningIcon);
}
