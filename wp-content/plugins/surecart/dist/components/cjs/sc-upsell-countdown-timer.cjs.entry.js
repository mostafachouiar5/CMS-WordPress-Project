'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');
const getters = require('./getters-f6bbfe30.js');
require('./store-d24717c6.js');
require('./utils-ee1bb9d3.js');
require('./index-bcdafe6e.js');

const scUpsellCountdownTimerCss = ":host{display:flex;justify-content:var(--sc-upsell-countdown-timer-justify-content, center);align-items:var(--sc-upsell-countdown-timer-align-items, center);text-align:var(--sc-upsell-countdown-timer-text-align, center);flex-wrap:wrap;gap:var(--sc-upsell-countdown-timer-gap, 0.5em);line-height:1;padding:var(--sc-upsell-countdown-timer-padding, var(--sc-spacing-medium));border-radius:var(--sc-upsell-countdown-timer-border-radius, var(--sc-border-radius-pill));background-color:var(--sc-upsell-countdown-timer-background-color, rgb(226, 249, 235));color:var(--sc-upsell-countdown-timer-color, rgb(71, 91, 80))}";
const ScUpsellCountdownTimerStyle0 = scUpsellCountdownTimerCss;

const ScUpsellCountdownTimer = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.timeRemaining = Infinity;
        this.formattedTime = undefined;
        this.showIcon = true;
    }
    componentDidLoad() {
        this.updateCountdown();
    }
    updateCountdown() {
        this.formattedTime = getters.getFormattedRemainingTime();
        setInterval(() => {
            this.formattedTime = getters.getFormattedRemainingTime();
        }, 1000);
    }
    render() {
        return (index.h(index.Host, { key: '78ffae153baefe9b9f84d129dcfac5370212a2a2', role: "timer", class: {
                'sc-upsell-countdown-timer': true,
            } }, this.showIcon && index.h("sc-icon", { key: 'f0178828c7e0cc28f8ca0c93890e8e3077b0dbb9', name: "clock" }), index.h("span", { key: '0e673c27efd949f1ea8fcde7cb975ff2df63c8ad' }, index.h("slot", { key: '61eb5079b0faca31fdf489c5cb55b29da88e767b', name: "offer-expire-text" }), " ", index.h("strong", { key: '2e1a5878b38413411dd0487fe66b7152e3687f7e' }, this.formattedTime))));
    }
};
ScUpsellCountdownTimer.style = ScUpsellCountdownTimerStyle0;

exports.sc_upsell_countdown_timer = ScUpsellCountdownTimer;

//# sourceMappingURL=sc-upsell-countdown-timer.cjs.entry.js.map