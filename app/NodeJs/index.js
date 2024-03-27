import puppeteer from 'puppeteer';
import  puppeteerExtra from 'puppeteer-extra';
import Stealth from 'puppeteer-extra-plugin-stealth';
import process from 'process';

puppeteerExtra.use(Stealth());


 const url = process.argv[2]; 

export const scrapping = async () => {
  let imageUrls = [];
  try{
  const browserObj = await puppeteerExtra.launch();
  const newpage = await browserObj.newPage();
  await newpage.setViewport({ width: 1280, height: 720 });
  
 
  await newpage.setUserAgent(
    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36');


  await newpage.goto(url,{ timeout: 60000 });
  await new Promise(resolve => setTimeout(resolve, 100));
  // scrapping code for title
const titleNode = await newpage.$('.a-size-large.a-spacing-none.a-color-secondary');
const titleNode1 = await newpage.$('.a-size-large.product-title-word-break');

if (titleNode){
  var title = await newpage.evaluate(el => el.innerText, titleNode);
} else if(titleNode1){
  var title = await newpage.evaluate(el => el.innerText, titleNode1);

}
else{
 var title  = "Title Blocked By Amazone";
}

// scrapping code for price set it for price range and only price
const priceNode = await newpage.$('.a-price-range');
const priceNode1 = await newpage.$('.a-price.a-text-price.a-size-medium.apexPriceToPay'); 
const priceNode2 = await newpage.$('.a-price.aok-align-center.reinventPricePriceToPayMargin.priceToPay'); 
var priceRange = 0; 
var price = 0;
if(priceNode){
  var priceRange = await newpage.evaluate(el => el.innerText, priceNode);
} else if(priceNode1){
  var price = await newpage.evaluate(el => el.innerText, priceNode1);
}else if(priceNode2){
  var price = await newpage.evaluate(el => el.innerText, priceNode2);
}else{
  var price = 0;

}


// scrapping code for product info array
// var productNode = await newpage.$('.a-section.feature.detail-bullets-wrapper.bucket');
// var productNumber = await newpage.evaluate(el =>el.innerText, productNode);



// scrapping for image
await newpage.waitForSelector('.imgTagWrapper img');
var imageSrc = await newpage.evaluate(() => {
  const img = document.querySelector('.imgTagWrapper img');
  return img ? img.getAttribute('src') : "https://odoo-community.org/web/image/product.product/19823/image_1024/Default%20Product%20Images?unique=7fcafe2";
});
   imageUrls =(JSON.stringify({title , priceRange , price , imageSrc}));
  await browserObj.close();
  return (imageUrls);
  // process.exit(1);
}
catch (error) {
  console.error(error);
  //  throw new Error(error)
  await browserObj.close();
   process.exit(1);
  
}
};
scrapping().then(result => {
  console.log(result);
  // console.log('hogaya');
})
.catch(error => {
  console.error(error); 
  process.exit(1);
});

