import { r as registerInstance, h } from './index-745b6bec.js';

const scAvatarCss = ":host{display:inline-block;--sc-avatar-size:3rem}.avatar{display:inline-flex;align-items:center;justify-content:center;position:relative;width:var(--sc-avatar-size);height:var(--sc-avatar-size);background-color:var(--sc-color-gray-400);font-family:var(--sc-font-sans);font-size:calc(var(--sc-avatar-size) * 0.5);font-weight:var(--sc-font-weight-normal);color:var(--sc-color-white);user-select:none;vertical-align:middle}.avatar--circle,.avatar--circle .avatar__image{border-radius:var(--sc-border-radius-circle)}.avatar--rounded,.avatar--rounded .avatar__image{border-radius:var(--sc-border-radius-medium)}.avatar--square{border-radius:0}.avatar__icon{display:flex;align-items:center;justify-content:center;position:absolute;top:0;left:0;width:100%;height:100%}.avatar__initials{line-height:1;text-transform:uppercase}.avatar__image{position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;overflow:hidden}";
const ScAvatarStyle0 = scAvatarCss;

const ScAvatar = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.hasError = false;
        this.image = '';
        this.label = '';
        this.initials = '';
        this.loading = 'eager';
        this.shape = 'circle';
    }
    handleImageChange() {
        // Reset the error when a new image is provided
        this.hasError = false;
    }
    render() {
        return (h("div", { key: 'ee7ef03aa44c27af7255d070d102c93e0a6c1c1a', part: "base", class: {
                'avatar': true,
                'avatar--circle': this.shape === 'circle',
                'avatar--rounded': this.shape === 'rounded',
                'avatar--square': this.shape === 'square',
            }, role: "img", "aria-label": this.label }, this.initials ? (h("div", { part: "initials", class: "avatar__initials" }, this.initials)) : (h("div", { part: "icon", class: "avatar__icon", "aria-hidden": "true" }, h("slot", { name: "icon" }, h("sl-icon", { name: "person-fill", library: "system" })))), this.image && !this.hasError && h("img", { key: '122410026ec31bac9744563c4e286e8b497fd4ff', part: "image", class: "avatar__image", src: this.image, loading: this.loading, alt: "", onError: () => (this.hasError = true) })));
    }
    static get watchers() { return {
        "image": ["handleImageChange"]
    }; }
};
ScAvatar.style = ScAvatarStyle0;

export { ScAvatar as sc_avatar };

//# sourceMappingURL=sc-avatar.entry.js.map