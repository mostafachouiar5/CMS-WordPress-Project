import{h}from"@stencil/core";import{__,sprintf}from"@wordpress/i18n";import{addQueryArgs}from"@wordpress/url";import apiFetch from"../../../../functions/fetch";import{intervalString}from"../../../../functions/price";import{productNameWithPrice}from"../../../../functions/price";import{formatTime}from"../../../../../../admin/util/time";import{formatNumber}from"../../../../../../admin/util";export class ScSubscriptionDetails{constructor(){this.subscription=void 0,this.pendingPrice=void 0,this.hideRenewalText=void 0,this.activationsModal=void 0,this.loading=void 0,this.hasPendingUpdate=void 0}renderName(){var i,t,e;return"string"!=typeof(null===(t=null===(i=this.subscription)||void 0===i?void 0:i.price)||void 0===t?void 0:t.product)?productNameWithPrice(null===(e=this.subscription)||void 0===e?void 0:e.price):__("Subscription","surecart")}async handleSubscriptionChange(){var i,t,e,n;this.hasPendingUpdate=!!(null===(t=Object.keys((null===(i=null==this?void 0:this.subscription)||void 0===i?void 0:i.pending_update)||{}))||void 0===t?void 0:t.length),!(null===(n=null===(e=null==this?void 0:this.subscription)||void 0===e?void 0:e.pending_update)||void 0===n?void 0:n.price)||(null==this?void 0:this.pendingPrice)||this.hideRenewalText||(this.pendingPrice=await this.fetchPrice(this.subscription.pending_update.price))}componentWillLoad(){this.handleSubscriptionChange()}async fetchPrice(i){try{return this.loading=!0,await apiFetch({path:addQueryArgs(`surecart/v1/prices/${i}`,{expand:["product"]})})}catch(i){console.error(i)}finally{this.loading=!1}}renderRenewalText(){var i,t,e,n,s,r,o,a,d,c,l,u,p,v,m,b,_,f,g,y,w,_x,x,P;const k=h("sc-subscription-status-badge",{subscription:null==this?void 0:this.subscription});return(null===(i=null==this?void 0:this.subscription)||void 0===i?void 0:i.cancel_at_period_end)&&(null===(t=null==this?void 0:this.subscription)||void 0===t?void 0:t.current_period_end_at)?h("span",{"aria-label":sprintf(__("Renewal Update - Your plan will be canceled on %s","surecart"),formatTime(this.subscription.current_period_end_at))},k," ",sprintf(__("Your plan will be canceled on","surecart"))," ",h("sc-format-date",{date:1e3*this.subscription.current_period_end_at,month:"long",day:"numeric",year:"numeric"})):this.hasPendingUpdate?this.pendingPrice||(null===(n=null===(e=this.subscription)||void 0===e?void 0:e.pending_update)||void 0===n?void 0:n.ad_hoc_amount)?(null===(r=null===(s=this.subscription)||void 0===s?void 0:s.pending_update)||void 0===r?void 0:r.ad_hoc_amount)?h("span",{"aria-label":sprintf(__("Renewal Update - Your plan switches to %1$s on %2$s","surecart"),formatNumber(null===(a=null===(o=this.subscription)||void 0===o?void 0:o.pending_update)||void 0===a?void 0:a.ad_hoc_amount,(null===(d=this.pendingPrice)||void 0===d?void 0:d.currency)||(null===(l=null===(c=this.subscription)||void 0===c?void 0:c.price)||void 0===l?void 0:l.currency)),formatTime(this.subscription.current_period_end_at))},__("Your plan switches to","surecart")," ",h("strong",null,h("sc-format-number",{type:"currency",currency:(null===(u=this.pendingPrice)||void 0===u?void 0:u.currency)||(null===(v=null===(p=this.subscription)||void 0===p?void 0:p.price)||void 0===v?void 0:v.currency),value:null===(b=null===(m=this.subscription)||void 0===m?void 0:m.pending_update)||void 0===b?void 0:b.ad_hoc_amount})," ",intervalString(this.pendingPrice||(null===(_=this.subscription)||void 0===_?void 0:_.price)))," ",__("on","surecart")," ",h("sc-format-date",{date:this.subscription.current_period_end_at,type:"timestamp",month:"long",day:"numeric",year:"numeric"})):h("span",{"aria-label":sprintf(__("Renewal Update - Your plan switches to %1$s on %2$s","surecart"),this.pendingPrice.product.name,formatTime(this.subscription.current_period_end_at))},__("Your plan switches to","surecart")," ",h("strong",null,this.pendingPrice.product.name)," ",__("on","surecart")," ",h("sc-format-date",{date:this.subscription.current_period_end_at,type:"timestamp",month:"long",day:"numeric",year:"numeric"})):h("sc-skeleton",null):"trialing"===(null===(f=null==this?void 0:this.subscription)||void 0===f?void 0:f.status)&&(null===(g=null==this?void 0:this.subscription)||void 0===g?void 0:g.trial_end_at)?h("span",{"aria-label":sprintf(__("Renewal Update - Your plan begins on %s.","surecart"),formatTime(this.subscription.trial_end_at))},k," ",sprintf(__("Your plan begins on","surecart"))," ",h("sc-format-date",{date:null===(y=null==this?void 0:this.subscription)||void 0===y?void 0:y.trial_end_at,type:"timestamp",month:"long",day:"numeric",year:"numeric"})):"active"===(null===(w=this.subscription)||void 0===w?void 0:w.status)&&(null===(_x=this.subscription)||void 0===_x?void 0:_x.current_period_end_at)?h("span",{"aria-label":sprintf(__("Renewal Update - Your next payment is on %s","surecart"),formatTime(this.subscription.current_period_end_at))},k," ",null===(null===(x=this.subscription)||void 0===x?void 0:x.remaining_period_count)?__("Your plan renews on","surecart"):__("Your next payment is on","surecart")," ",h("sc-format-date",{date:null===(P=null==this?void 0:this.subscription)||void 0===P?void 0:P.current_period_end_at,type:"timestamp",month:"long",day:"numeric",year:"numeric"})):k}getActivations(){var i,t,e,n;return((null===(n=null===(e=null===(t=null===(i=this.subscription)||void 0===i?void 0:i.purchase)||void 0===t?void 0:t.license)||void 0===e?void 0:e.activations)||void 0===n?void 0:n.data)||[]).filter((i=>null==i?void 0:i.counted))}renderActivations(){var i;const t=this.getActivations();return(null==t?void 0:t.length)?h("sc-flex",{justifyContent:"flex-start",alignItems:"center"},h("sc-tag",{size:"small"},null===(i=null==t?void 0:t[0])||void 0===i?void 0:i.name),(null==t?void 0:t.length)>1&&h("sc-text",{style:{"--font-size":"var(--sc-font-size-small)",cursor:"pointer"},onClick:i=>{i.preventDefault(),i.stopImmediatePropagation(),this.activationsModal=!0}},"+ ",(null==t?void 0:t.length)-1," More")):null}showWarning(){var i,t,e,n,s,r,o;return!(null===(i=this.subscription)||void 0===i?void 0:i.payment_method)&&!this.subscription.manual_payment&&!!["active","past_due","unpaid","incomplete"].includes(null===(t=this.subscription)||void 0===t?void 0:t.status)&&((null===(n=null===(e=this.subscription)||void 0===e?void 0:e.price)||void 0===n?void 0:n.ad_hoc)?0!==(null===(s=this.subscription)||void 0===s?void 0:s.ad_hoc_amount):0!==(null===(o=null===(r=this.subscription)||void 0===r?void 0:r.price)||void 0===o?void 0:o.amount))}render(){return h("div",{key:"b36abe13480088de76ca6316f718a3e57fe30460",class:"subscription-details"},this.hasPendingUpdate&&h("div",{key:"579bb7fb96b8ccc7affd6aeab3721c378f9eedb2"},h("sc-tag",{key:"13af9cd0198606d4dae16383f2f7da5be4c1b956",size:"small",type:"warning"},__("Update Scheduled","surecart"))),h("sc-flex",{key:"73608895b32a191b388c10fd42901053e679bda3",alignItems:"center",justifyContent:"flex-start"},h("sc-text",{key:"037006c291a1dcb4b14c3cdf1afd6e940f361eba","aria-label":sprintf(__("Plan name - %s","surecart"),this.renderName()),style:{"--font-weight":"var(--sc-font-weight-bold)"}},this.renderName()),this.renderActivations()),!this.hideRenewalText&&h("div",{key:"3fa3d2b627e068310a583d97b00a3ce300cd4c8c"},this.renderRenewalText()," "),h("slot",{key:"165e93dbc2aa65ffdd093bf5f413aa09b3011310"}),h("sc-dialog",{key:"24c0e4e7157a4f8ac1875cc169a0bfe782f7d2b3",label:__("Activations","surecart"),onScRequestClose:()=>this.activationsModal=!1,open:!!this.activationsModal},h("sc-card",{key:"89b8147fa47934c1dc4f13a71378f4930abd6704","no-padding":!0,style:{"--overflow":"hidden"}},h("sc-stacked-list",{key:"1fd44c8cc0e78d728837a68e1812f9b95c59e5d4"},(this.getActivations()||[]).map((i=>h("sc-stacked-list-row",{style:{"--columns":"2"},mobileSize:0},h("sc-text",{style:{"--line-height":"var(--sc-line-height-dense)"}},h("strong",null,null==i?void 0:i.name),h("div",null,h("sc-text",{style:{"--color":"var(--sc-color-gray-500)"}},null==i?void 0:i.fingerprint))),h("sc-text",{style:{"--color":"var(--sc-color-gray-500)"}},h("sc-format-date",{type:"timestamp",month:"short",day:"numeric",year:"numeric",date:null==i?void 0:i.created_at})))))))),this.showWarning()&&h("div",{key:"9150a04f32fcf63527712d83d787ab95cfcd935f"},h("sc-tag",{key:"5bbc7131e1ec3485529dbe91f03f3941c8cda449",type:"warning"},h("div",{key:"f8b38c1fe9198c4d48c854cc1462ddbd922d0d84",class:"subscription-details__missing-method"},h("sc-icon",{key:"ac9059aa2b58a2d0e8ea7d8276e2642832db78f9",name:"alert-triangle"}),__("Payment Method Missing","surecart")))))}static get is(){return"sc-subscription-details"}static get encapsulation(){return"shadow"}static get originalStyleUrls(){return{$:["sc-subscription-details.css"]}}static get styleUrls(){return{$:["sc-subscription-details.css"]}}static get properties(){return{subscription:{type:"unknown",mutable:!1,complexType:{original:"Subscription",resolved:"Subscription",references:{Subscription:{location:"import",path:"../../../../types",id:"src/types.ts::Subscription"}}},required:!1,optional:!1,docs:{tags:[],text:""}},pendingPrice:{type:"unknown",mutable:!1,complexType:{original:"Price",resolved:"Price",references:{Price:{location:"import",path:"../../../../types",id:"src/types.ts::Price"}}},required:!1,optional:!1,docs:{tags:[],text:""}},hideRenewalText:{type:"boolean",mutable:!1,complexType:{original:"boolean",resolved:"boolean",references:{}},required:!1,optional:!1,docs:{tags:[],text:""},attribute:"hide-renewal-text",reflect:!1}}}static get states(){return{activationsModal:{},loading:{},hasPendingUpdate:{}}}static get watchers(){return[{propName:"subscription",methodName:"handleSubscriptionChange"}]}}