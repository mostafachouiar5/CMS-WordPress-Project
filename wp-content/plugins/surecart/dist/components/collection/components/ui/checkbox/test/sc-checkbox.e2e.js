import{newE2EPage}from"@stencil/core/testing";describe("sc-checkbox",(()=>{it("renders",(async()=>{const e=await newE2EPage();await e.setContent("<sc-checkbox></sc-checkbox>");const c=await e.find("sc-checkbox");expect(c).toHaveClass("hydrated")}))}));