import{newE2EPage}from"@stencil/core/testing";describe("sc-prose",(()=>{it("renders",(async()=>{const e=await newE2EPage();await e.setContent("<sc-prose></sc-prose>");const s=await e.find("sc-prose");expect(s).toHaveClass("hydrated")}))}));