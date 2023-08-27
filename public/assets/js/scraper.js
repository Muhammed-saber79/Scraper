import puppeteer from "puppeteer";

(async () => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    const urlToScrap = process.argv[2];
    await page.goto(urlToScrap);

    await page.waitForSelector(".download-button a");

    // Extraxt link...
    const download_link = await page.$eval('.download-button a', link => link.href);
    console.log(download_link);

    await browser.close();
})()