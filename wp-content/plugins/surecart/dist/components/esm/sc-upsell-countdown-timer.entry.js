import { r as registerInstance, h, H as Host } from './index-745b6bec.js';
import { d as getFormattedRemainingTime } from './getters-b1d93841.js';
import './store-dcefd119.js';
import './utils-e9ee502a.js';
import './index-06061d4e.js';

const scUpsellCountdownTimerCss = ":host{display:flex;justify-content:var(--sc-upsell-countdown-timer-justify-content, center);align-items:var(--sc-upsell-countdown-timer-align-items, center);text-align:var(--sc-upsell-countdown-timer-text-align, center);flex-wrap:wrap;gap:var(--sc-upsell-countdown-timer-gap, 0.5em);line-height:1;padding:var(--sc-upsell-countdown-timer-padding, var(--sc-spacing-medium));border-radius:var(--sc-upsell-countdown-timer-border-radius, var(--sc-border-radius-pill));background-color:var(--sc-upsell-countdown-timer-background-color, rgb(226, 249, 235));color:var(--sc-upsell-countdown-timer-color, rgb(71, 91, 80))}";
const ScUpsellCountdownTimerStyle0 = scUpsellCountdownTimerCss;

const ScUpsellCountdownTimer = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.timeRemaining = Infinity;
        this.formattedTime = undefined;
        this.showIcon = true;
    }
    componentDidLoad() {
        this.updateCountdown();
    }
    updateCountdown() {
        this.formattedTime = getFormattedRemainingTime();
        setInterval(() => {
            this.formattedTime = getFormattedRemainingTime();
        }, 1000);
    }
    render() {
        return (h(Host, { key: '78ffae153baefe9b9f84d129dcfac5370212a2a2', role: "timer", class: {
                'sc-upsell-countdown-timer': true,
            } }, this.showIcon && h("sc-icon", { key: 'f0178828c7e0cc28f8ca0c93890e8e3077b0dbb9', name: "clock" }), h("span", { key: '0e673c27efd949f1ea8fcde7cb975ff2df63c8ad' }, h("slot", { key: '61eb5079b0faca31fdf489c5cb55b29da88e767b', name: "offer-expire-text" }), " ", h("strong", { key: '2e1a5878b38413411dd0487fe66b7152e3687f7e' }, this.formattedTime))));
    }
};
ScUpsellCountdownTimer.style = ScUpsellCountdownTimerStyle0;

export { ScUpsellCountdownTimer as sc_upsell_countdown_timer };

//# sourceMappingURL=sc-upsell-countdown-timer.entry.js.map