'use strict';

Object.defineProperty(exports, '__esModule', { value: true });

const index = require('./index-8acc3c89.js');

const scBadgeNoticeCss = ":host{display:block}.notice{background:var(--sc-badge-notice-background-color, var(--sc-color-white));color:var(--sc-badge-notice-text-color, var(--sc-color-gray-950));border:solid 1px var(--sc-badge-notice-border-color, var(--sc-color-white));border-radius:var(--sc-border-radius-small);padding:var(--sc-spacing-small);font-size:var(--sc-font-size-x-small);display:flex;gap:0.5em;line-height:1}.notice--warning{background:var(--sc-color-warning-50);color:var(--sc-color-warning-700)}";
const ScBadgeNoticeStyle0 = scBadgeNoticeCss;

const ScBadgeNotice = class {
    constructor(hostRef) {
        index.registerInstance(this, hostRef);
        this.type = 'primary';
        this.label = undefined;
        this.size = 'small';
    }
    render() {
        return (index.h("div", { key: '103201e03b1b682db7d27e3600af43503ba191b4', class: {
                'notice': true,
                'notice--is-small': this.size === 'small',
                'notice--is-medium': this.size === 'medium',
                'notice--is-large': this.size === 'large',
                'notice--primary': this.type === 'primary',
                'notice--success': this.type === 'success',
                'notice--warning': this.type === 'warning',
                'notice--danger': this.type === 'danger',
                'notice--default': this.type === 'default',
            } }, index.h("sc-tag", { key: '8ce5d5f58edc4baabd9664e1f856db9e01e34fe3', size: this.size, type: this.type }, this.label), index.h("slot", { key: 'd40df25872f8a1c907c8fedc1ee3ca2d2bee87ef' })));
    }
};
ScBadgeNotice.style = ScBadgeNoticeStyle0;

exports.sc_badge_notice = ScBadgeNotice;

//# sourceMappingURL=sc-badge-notice.cjs.entry.js.map