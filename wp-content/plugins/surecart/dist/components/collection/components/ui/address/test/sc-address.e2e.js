import{newE2EPage}from"@stencil/core/testing";describe("sc-address",(()=>{it("renders",(async()=>{const s=await newE2EPage();await s.setContent("<sc-address></sc-address>");const e=await s.find("sc-address");expect(e).toHaveClass("hydrated")}))}));