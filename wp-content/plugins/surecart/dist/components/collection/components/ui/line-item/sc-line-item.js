import{h}from"@stencil/core";import{isRtl}from"../../../functions/page-align";export class ScLineItem{constructor(){this.price=void 0,this.currency=void 0,this.hasImageSlot=void 0,this.hasTitleSlot=void 0,this.hasDescriptionSlot=void 0,this.hasPriceSlot=void 0,this.hasPriceDescriptionSlot=void 0,this.hasCurrencySlot=void 0}componentWillLoad(){this.hasImageSlot=!!this.hostElement.querySelector('[slot="image"]'),this.hasTitleSlot=!!this.hostElement.querySelector('[slot="title"]'),this.hasDescriptionSlot=!!this.hostElement.querySelector('[slot="description"]'),this.hasPriceSlot=!!this.hostElement.querySelector('[slot="price"]'),this.hasPriceDescriptionSlot=!!this.hostElement.querySelector('[slot="price-description"]'),this.hasCurrencySlot=!!this.hostElement.querySelector('[slot="currency"]')}render(){return h("div",{key:"81fbd87e15174d0e85c97a92e55003d175a36a1f",part:"base",class:{item:!0,"item--has-image":this.hasImageSlot,"item--has-title":this.hasTitleSlot,"item--has-description":this.hasDescriptionSlot,"item--has-price":this.hasPriceSlot,"item--has-price-description":this.hasPriceDescriptionSlot,"item--has-price-currency":this.hasCurrencySlot,"item--is-rtl":isRtl()}},h("div",{key:"b87d1cb75340a9c6bc50e41409652b9b074e6a33",class:"item__image",part:"image"},h("slot",{key:"509f019750ddf01b906508b4f6c56daf6a115065",name:"image"})),h("div",{key:"4ab68f58591454a0d14406f8259dc31ac583885b",class:"item__text",part:"text"},h("div",{key:"61f98363f424d785ff63c06374862c14df4c743d",class:"item__title",part:"title"},h("slot",{key:"702a5ff5223a1ccc19e5d932eae5f8e28686cb70",name:"title"})),h("div",{key:"2343778a44d7af3de1ec74ea3a9bcd8795d9e102",class:"item__description",part:"description"},h("slot",{key:"85643c53086ff4f89cdbf09b518615a5c005aec2",name:"description"}))),h("div",{key:"0e6e9dc872092228a2a59509c0ee811f6c785dc5",class:"item__end",part:"price"},h("div",{key:"76847c2426d11eaf8209dc498a5015b6c53ca125",class:"item__price-currency",part:"currency"},h("slot",{key:"2fbbfa520a9ba5e0a2b9d6ccdf7eb440e1f04b76",name:"currency"})),h("div",{key:"5c56e81138a766dba8b66109a487e8b056e0a5c0",class:"item__price-text",part:"price-text"},h("div",{key:"113bba1653dab380f43104d8e064fb590d415f25",class:"item__price",part:"price"},h("slot",{key:"f0c644f4a2b01cc6b4f750d4cb9a0cfec095d7c4",name:"price"})),h("div",{key:"440b9e221c7dfb8a6b533f95617036ce28ae7b10",class:"item__price-description",part:"price-description"},h("slot",{key:"a81319dc1b6c80a9739b4207254a9f3b07acae25",name:"price-description"})))))}static get is(){return"sc-line-item"}static get encapsulation(){return"shadow"}static get originalStyleUrls(){return{$:["sc-line-item.scss"]}}static get styleUrls(){return{$:["sc-line-item.css"]}}static get properties(){return{price:{type:"string",mutable:!1,complexType:{original:"string",resolved:"string",references:{}},required:!1,optional:!1,docs:{tags:[],text:"Price of the item"},attribute:"price",reflect:!1},currency:{type:"string",mutable:!1,complexType:{original:"string",resolved:"string",references:{}},required:!1,optional:!1,docs:{tags:[],text:"Currency symbol"},attribute:"currency",reflect:!1}}}static get states(){return{hasImageSlot:{},hasTitleSlot:{},hasDescriptionSlot:{},hasPriceSlot:{},hasPriceDescriptionSlot:{},hasCurrencySlot:{}}}static get elementRef(){return"hostElement"}}