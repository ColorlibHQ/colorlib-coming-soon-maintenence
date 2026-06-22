/*
 * Coming Soon & Maintenance by Colorlib — shared front-end script (vanilla JS).
 *
 * Replaces jQuery plus the per-template main.js, countdowntime.js, FlipClock and
 * Tilt plugins. Every feature is guarded so it only runs when its markup exists.
 */
(function () {
	'use strict';

	/* ----------------------------------------------------------------------
	 * Subscribe form validation
	 * -------------------------------------------------------------------- */
	var EMAIL_RE = /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/;

	function isValid(input) {
		var value = input.value.trim();
		if (input.type === 'email' || input.name === 'email') {
			return EMAIL_RE.test(value);
		}
		return value !== '';
	}

	function showValidate(input) {
		if (input.parentElement) {
			input.parentElement.classList.add('alert-validate');
		}
	}

	function hideValidate(input) {
		if (input.parentElement) {
			input.parentElement.classList.remove('alert-validate');
		}
	}

	function initValidation() {
		var forms = document.querySelectorAll('.validate-form');

		forms.forEach(function (form) {
			var inputs = form.querySelectorAll('.validate-input .input100');

			form.addEventListener('submit', function (event) {
				var ok = true;
				inputs.forEach(function (input) {
					if (!isValid(input)) {
						showValidate(input);
						ok = false;
					}
				});
				if (!ok) {
					event.preventDefault();
				}
			});

			inputs.forEach(function (input) {
				input.addEventListener('focus', function () {
					hideValidate(input);
				});
			});
		});
	}

	/* ----------------------------------------------------------------------
	 * Full-screen background slideshow (cross-fade)
	 * -------------------------------------------------------------------- */
	function initSlideshow() {
		document.querySelectorAll('.simpleslide100').forEach(function (slider) {
			var items = slider.querySelectorAll('.simpleslide100-item');
			if (!items.length) {
				return;
			}

			items.forEach(function (item, index) {
				item.style.transition = 'opacity 1s ease';
				item.style.opacity = index === 0 ? '1' : '0';
				item.style.display = 'block';
			});

			if (items.length < 2) {
				return;
			}

			var current = 0;
			setInterval(function () {
				items[current].style.opacity = '0';
				current = (current + 1) % items.length;
				items[current].style.opacity = '1';
			}, 7000);
		});
	}

	/* ----------------------------------------------------------------------
	 * Subscribe modal (template_04)
	 * -------------------------------------------------------------------- */
	function closeModal(modal) {
		if (modal) {
			modal.classList.remove('show');
		}
	}

	function initModal() {
		document.querySelectorAll('[data-ccsm-modal]').forEach(function (trigger) {
			trigger.addEventListener('click', function (event) {
				event.preventDefault();
				var modal = document.getElementById(trigger.getAttribute('data-ccsm-modal'));
				if (modal) {
					modal.classList.add('show');
				}
			});
		});

		document.querySelectorAll('.modal').forEach(function (modal) {
			modal.addEventListener('click', function (event) {
				if (event.target === modal || event.target.classList.contains('modal-dialog')) {
					closeModal(modal);
				}
			});
		});

		document.querySelectorAll('.btn-close-modal').forEach(function (button) {
			button.addEventListener('click', function () {
				closeModal(button.closest('.modal'));
			});
		});

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') {
				document.querySelectorAll('.modal.show').forEach(closeModal);
			}
		});
	}

	/* ----------------------------------------------------------------------
	 * Tilt effect (template_01)
	 * -------------------------------------------------------------------- */
	function initTilt() {
		if (window.matchMedia && window.matchMedia('(hover: none)').matches) {
			return; // Skip on touch devices.
		}

		document.querySelectorAll('.js-tilt').forEach(function (el) {
			var max = 15;
			el.style.transition = 'transform 0.15s ease-out';
			el.style.transformStyle = 'preserve-3d';
			el.style.willChange = 'transform';

			el.addEventListener('mousemove', function (event) {
				var rect = el.getBoundingClientRect();
				var px = (event.clientX - rect.left) / rect.width;
				var py = (event.clientY - rect.top) / rect.height;
				var rotateX = (py - 0.5) * -2 * max;
				var rotateY = (px - 0.5) * 2 * max;
				el.style.transform = 'perspective(1000px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg) scale(1.1)';
			});

			el.addEventListener('mouseleave', function () {
				el.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale(1)';
			});
		});
	}

	/* ----------------------------------------------------------------------
	 * Countdown timer
	 * -------------------------------------------------------------------- */
	function pad(value) {
		return (value < 10 ? '0' : '') + value;
	}

	function setDigit(clock, selector, value) {
		var el = clock.querySelector(selector);
		if (el) {
			el.textContent = value;
		}
	}

	function initCountdown() {
		var config = window.CCSM_COUNTDOWN;
		var clocks = document.querySelectorAll('.cd100');
		if (!config || !clocks.length) {
			return;
		}

		var target = new Date(
			Number(config.year),
			Number(config.month) - 1,
			Number(config.day),
			Number(config.hour),
			Number(config.minute),
			Number(config.second)
		).getTime();

		if (isNaN(target)) {
			return;
		}

		var timer = setInterval(tick, 1000);
		tick();

		function tick() {
			var remaining = Math.max(0, target - Date.now());
			var totalSeconds = Math.floor(remaining / 1000);
			var days = Math.floor(totalSeconds / 86400);
			var hours = Math.floor((totalSeconds % 86400) / 3600);
			var minutes = Math.floor((totalSeconds % 3600) / 60);
			var seconds = totalSeconds % 60;

			clocks.forEach(function (clock) {
				setDigit(clock, '.days', days);
				setDigit(clock, '.hours', pad(hours));
				setDigit(clock, '.minutes', pad(minutes));
				setDigit(clock, '.seconds', pad(seconds));
			});

			if (remaining <= 0) {
				clearInterval(timer);
			}
		}
	}

	/* -------------------------------------------------------------------- */
	function init() {
		initValidation();
		initSlideshow();
		initModal();
		initTilt();
		initCountdown();
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}
})();
