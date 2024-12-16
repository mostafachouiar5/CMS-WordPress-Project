import { r as registerInstance, h } from './index-745b6bec.js';
import { a as apiFetch } from './fetch-2032d11d.js';
import { a as addQueryArgs } from './add-query-args-0e2a8393.js';
import './remove-query-args-938c53ea.js';

const scDownloadsListCss = ":host{display:block}.purchase{display:flex;flex-direction:column;gap:var(--sc-spacing-large)}.single-download .single-download__preview{display:flex;align-items:center;justify-content:center;background:var(--sc-color-gray-200);border-radius:var(--sc-border-radius-small);height:4rem;min-width:4rem;width:4rem}";
const ScDownloadsListStyle0 = scDownloadsListCss;

const ScDownloadsList = class {
    constructor(hostRef) {
        registerInstance(this, hostRef);
        this.renderFileExt = download => {
            var _a, _b, _c, _d, _e, _f, _g, _h, _j;
            if ((_a = download === null || download === void 0 ? void 0 : download.media) === null || _a === void 0 ? void 0 : _a.filename) {
                return (_e = (_d = (_c = (_b = download.media.filename).split) === null || _c === void 0 ? void 0 : _c.call(_b, '.')) === null || _d === void 0 ? void 0 : _d.pop) === null || _e === void 0 ? void 0 : _e.call(_d);
            }
            if (download === null || download === void 0 ? void 0 : download.url) {
                try {
                    const url = new URL(download.url);
                    if (url.pathname.includes('.')) {
                        return (_j = (_h = (_g = (_f = url.pathname).split) === null || _g === void 0 ? void 0 : _g.call(_f, '.')) === null || _h === void 0 ? void 0 : _h.pop) === null || _j === void 0 ? void 0 : _j.call(_h);
                    }
                }
                catch (err) {
                    console.error(err);
                }
            }
            return h("sc-icon", { name: "file" });
        };
        this.downloads = undefined;
        this.customerId = undefined;
        this.heading = undefined;
        this.busy = undefined;
        this.error = undefined;
    }
    async downloadItem(download) {
        var _a, _b;
        if (download === null || download === void 0 ? void 0 : download.url) {
            this.downloadFile(download.url, (_a = download === null || download === void 0 ? void 0 : download.name) !== null && _a !== void 0 ? _a : 'file');
            return;
        }
        const mediaId = (_b = download === null || download === void 0 ? void 0 : download.media) === null || _b === void 0 ? void 0 : _b.id;
        if (!mediaId)
            return;
        try {
            this.busy = mediaId;
            const media = (await apiFetch({
                path: addQueryArgs(`surecart/v1/customers/${this.customerId}/expose/${mediaId}`, {
                    expose_for: 60,
                }),
            }));
            if (!(media === null || media === void 0 ? void 0 : media.url)) {
                throw {
                    message: wp.i18n.__('Could not download the file.', 'surecart'),
                };
            }
            this.downloadFile(media === null || media === void 0 ? void 0 : media.url, media.filename);
        }
        catch (e) {
            console.error(e);
            this.error = (e === null || e === void 0 ? void 0 : e.message) || wp.i18n.__('Something went wrong', 'surecart');
        }
        finally {
            this.busy = null;
        }
    }
    downloadFile(path, filename) {
        // Create a new link
        const anchor = document.createElement('a');
        anchor.href = path;
        anchor.download = filename;
        // Append to the DOM
        document.body.appendChild(anchor);
        // Trigger `click` event
        anchor.click();
        // To make this work on Firefox we need to wait
        // a little while before removing it.
        setTimeout(() => {
            document.body.removeChild(anchor);
        }, 0);
    }
    render() {
        const downloads = this.downloads || [];
        return (h("sc-dashboard-module", { key: '7ef3dca046fbcd55ff81c5ab92f52b2dd8630f3b', class: "purchase", part: "base", heading: wp.i18n.__('Downloads', 'surecart') }, h("span", { key: 'd3d95afb070f1fb26319c1002d02e5d075e196f0', slot: "heading" }, h("slot", { key: 'c35e1ad0ffa901edab292c0f10c9bd489e406478', name: "heading" }, this.heading || wp.i18n.__('Downloads', 'surecart'))), h("sc-card", { key: '8152d989ca16d8c791cb2fc5ace95d4211c56ad2', "no-padding": true }, h("sc-stacked-list", { key: '413b8f5775ea4f611adf3e513f6b2941fed45ca1' }, downloads.map(download => {
            var _a, _b, _c, _d;
            const media = download === null || download === void 0 ? void 0 : download.media;
            return (h("sc-stacked-list-row", { style: { '--columns': '1' } }, h("sc-flex", { class: "single-download", justifyContent: "flex-start", alignItems: "center" }, h("div", { class: "single-download__preview" }, this.renderFileExt(download)), h("div", null, h("div", null, h("strong", null, (_b = (_a = media === null || media === void 0 ? void 0 : media.filename) !== null && _a !== void 0 ? _a : download === null || download === void 0 ? void 0 : download.name) !== null && _b !== void 0 ? _b : '')), h("sc-flex", { justifyContent: "flex-start", alignItems: "center", style: { gap: '0.5em' } }, (media === null || media === void 0 ? void 0 : media.byte_size) && h("sc-format-bytes", { value: media.byte_size }), !!((_c = media === null || media === void 0 ? void 0 : media.release_json) === null || _c === void 0 ? void 0 : _c.version) && (h("sc-tag", { type: "primary", size: "small", style: {
                    '--sc-tag-primary-background-color': '#f3e8ff',
                    '--sc-tag-primary-color': '#6b21a8',
                } }, "v", (_d = media === null || media === void 0 ? void 0 : media.release_json) === null || _d === void 0 ? void 0 :
                _d.version))))), h("sc-button", { size: "small", slot: "suffix", onClick: () => this.downloadItem(download), busy: (media === null || media === void 0 ? void 0 : media.id) ? this.busy == (media === null || media === void 0 ? void 0 : media.id) : false, disabled: (media === null || media === void 0 ? void 0 : media.id) ? this.busy == (media === null || media === void 0 ? void 0 : media.id) : false }, wp.i18n.__('Download', 'surecart'))));
        })))));
    }
};
ScDownloadsList.style = ScDownloadsListStyle0;

export { ScDownloadsList as sc_downloads_list };

//# sourceMappingURL=sc-downloads-list.entry.js.map