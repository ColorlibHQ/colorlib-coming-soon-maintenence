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

	function isEmailField(input) {
		// Templates use name="EMAIL", so compare case-insensitively.
		return input.type === 'email' || String(input.name).toLowerCase() === 'email';
	}

	function isValid(input) {
		var value = input.value.trim();
		if (isEmailField(input)) {
			return EMAIL_RE.test(value);
		}
		return value !== '';
	}

	/**
	 * The message used to live only in a CSS ::before revealed on hover above
	 * 992px, so keyboard and screen reader users never learned why the form
	 * refused to submit. Render it as real text in a role="alert" region.
	 */
	function errorRegion(input) {
		var wrap = input.parentElement;
		if (!wrap) {
			return null;
		}

		var region = wrap.querySelector('.ccsm-field-error');
		if (!region) {
			region = document.createElement('span');
			region.className = 'ccsm-field-error';
			region.setAttribute('role', 'alert');
			region.id = 'ccsm-error-' + Math.random().toString(36).slice(2, 9);
			wrap.appendChild(region);
		}
		return region;
	}

	function showValidate(input) {
		var wrap = input.parentElement;
		if (wrap) {
			wrap.classList.add('alert-validate');
		}

		var region = errorRegion(input);
		if (region) {
			region.textContent = (wrap && wrap.getAttribute('data-validate')) || 'This field is required.';
			input.setAttribute('aria-describedby', region.id);
		}

		input.setAttribute('aria-invalid', 'true');
		input.classList.add('ccsm-input-invalid');
	}

	function hideValidate(input) {
		var wrap = input.parentElement;
		if (wrap) {
			wrap.classList.remove('alert-validate');
			var region = wrap.querySelector('.ccsm-field-error');
			if (region) {
				region.textContent = '';
			}
		}

		input.removeAttribute('aria-invalid');
		input.classList.remove('ccsm-input-invalid');
	}

	function initValidation() {
		var forms = document.querySelectorAll('.validate-form');

		forms.forEach(function (form) {
			var inputs = form.querySelectorAll('.validate-input .input100');

			form.addEventListener('submit', function (event) {
				var ok = true;
				var firstInvalid = null;

				inputs.forEach(function (input) {
					if (!isValid(input)) {
						showValidate(input);
						ok = false;
						if (!firstInvalid) {
							firstInvalid = input;
						}
					} else {
						hideValidate(input);
					}
				});

				if (!ok) {
					event.preventDefault();
					if (firstInvalid) {
						firstInvalid.focus();
					}
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
				item.style.transition = prefersReducedMotion() ? 'none' : 'opacity 1s ease';
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
	var FOCUSABLE = 'a[href], button:not([disabled]), input:not([disabled]), select, textarea, [tabindex]:not([tabindex="-1"])';
	var lastTrigger = null;

	function closeModal(modal) {
		if (!modal || !modal.classList.contains('show')) {
			return;
		}

		modal.classList.remove('show');
		modal.setAttribute('aria-hidden', 'true');

		// Return focus to whatever opened the dialog.
		if (lastTrigger && document.contains(lastTrigger)) {
			lastTrigger.focus();
		}
		lastTrigger = null;
	}

	function openModal(modal, trigger) {
		lastTrigger = trigger || null;
		modal.classList.add('show');
		modal.setAttribute('aria-modal', 'true');
		modal.removeAttribute('aria-hidden');

		var target = modal.querySelector(FOCUSABLE) || modal;
		if (target === modal && !modal.hasAttribute('tabindex')) {
			modal.setAttribute('tabindex', '-1');
		}
		target.focus();
	}

	/** Keep Tab inside the open dialog. */
	function trapFocus(modal, event) {
		var items = Array.prototype.filter.call(
			modal.querySelectorAll(FOCUSABLE),
			function (el) { return el.offsetParent !== null; }
		);
		if (!items.length) {
			return;
		}

		var first = items[0];
		var last = items[items.length - 1];

		if (event.shiftKey && document.activeElement === first) {
			event.preventDefault();
			last.focus();
		} else if (!event.shiftKey && document.activeElement === last) {
			event.preventDefault();
			first.focus();
		}
	}

	function initModal() {
		document.querySelectorAll('[data-ccsm-modal]').forEach(function (trigger) {
			trigger.addEventListener('click', function (event) {
				event.preventDefault();
				var modal = document.getElementById(trigger.getAttribute('data-ccsm-modal'));
				if (modal) {
					openModal(modal, trigger);
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
			var open = document.querySelector('.modal.show');
			if (!open) {
				return;
			}

			if (event.key === 'Escape') {
				closeModal(open);
			} else if (event.key === 'Tab') {
				trapFocus(open, event);
			}
		});
	}

	/* ----------------------------------------------------------------------
	 * Tilt effect (template_01)
	 * -------------------------------------------------------------------- */
	function prefersReducedMotion() {
		return window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	}

	function initTilt() {
		if (window.matchMedia && window.matchMedia('(hover: none)').matches) {
			return; // Skip on touch devices.
		}

		if (prefersReducedMotion()) {
			return;
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

		/*
		 * The digits rewrite themselves every second, which is noise in the
		 * accessibility tree and unreadable to a screen reader. Hide the
		 * ticking numbers and state the launch date once instead.
		 */
		var launch = new Date(target);
		var launchText = launch.toLocaleDateString(undefined, {
			year: 'numeric', month: 'long', day: 'numeric'
		});

		clocks.forEach(function (clock) {
			clock.setAttribute('aria-hidden', 'true');

			if (clock.previousElementSibling &&
				clock.previousElementSibling.classList.contains('ccsm-launch-date')) {
				return;
			}

			var note = document.createElement('p');
			note.className = 'ccsm-sr-only ccsm-launch-date';
			note.textContent = 'Launching on ' + launchText + '.';
			if (clock.parentNode) {
				clock.parentNode.insertBefore(note, clock);
			}
		});

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
