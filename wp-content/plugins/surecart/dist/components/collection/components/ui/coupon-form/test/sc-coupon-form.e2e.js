import{newE2EPage}from"@stencil/core/testing";describe("sc-coupon-form",(()=>{let a,t,e,o,n,i;const c="sc-coupon-form";beforeEach((async()=>{a=await newE2EPage(),await a.setContent(`<${c} label="Add A Coupon" collapsed></${c}>`),n=await a.find(`${c} >>> .coupon-form`),t=await a.find(`${c}`),e=await a.find(`${c} >>> .trigger`),o=await a.find(`${c} >>> sc-input >>> .input__control`),i=await a.find(`${c} >>> sc-button`)})),it("renders",(async()=>{expect(t).toHaveClass("hydrated")})),it("Has a loading state",(async()=>{t.setProperty("loading",!0),await a.waitForChanges();const e=await a.find(`${c} >>> sc-skeleton`);expect(e).not.toBeNull()})),it("Can toggle coupon field",(async()=>{expect(n).not.toHaveClass("coupon-form--is-open"),expect(e).toBeDefined(),await e.click(),await a.waitForChanges(),expect(n).toHaveClass("coupon-form--is-open")})),it("Triggers a coupon apply event",(async()=>{const t=await a.spyOnEvent("scApplyCoupon");await e.click(),await a.waitForChanges(),await o.type("TESTCOUPON"),await i.click(),await a.waitForChanges(),expect(t).toHaveReceivedEventDetail("TESTCOUPON")}))}));