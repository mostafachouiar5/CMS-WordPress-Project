import{ScLicensesList}from"../sc-licenses-list";import{newSpecPage}from"@stencil/core/testing";describe("sc-licenses-list",(()=>{it("renders",(async()=>{const e=await newSpecPage({components:[ScLicensesList],html:"<sc-licenses-list></sc-licenses-list>"});expect(e.root).toMatchSnapshot()})),it("Should render heading that is passed as a prop",(async()=>{const e=await newSpecPage({components:[ScLicensesList],html:'<sc-licenses-list heading="Test Heading"></sc-licenses-list>'});expect(e.root).toMatchSnapshot()})),it("Should render View all when the link is provided",(async()=>{const e=await newSpecPage({components:[ScLicensesList],html:"<sc-licenses-list heading=\"Test Heading\" all-link='www.test.com'></sc-licenses-list>"});expect(e.root).toMatchSnapshot()}))}));