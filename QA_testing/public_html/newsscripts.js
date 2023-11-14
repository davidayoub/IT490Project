// script.js

const RSSParser = require('rss-parser');

const parser = new RSSParser();

const feedURL = 'https://blog.coinmarketcap.com/feed/';

const newsFeedContainer = document.getElementById('news-feed');

// Function to fetch and display the RSS news feed
async function displayNewsFeed() {
    try {
        const feed = await parser.parseURL(feedURL);

        if (feed.items && feed.items.length > 0) {
            const newsItems = feed.items;
            const newsHTML = newsItems.map(item => `
                <div class="news-item">
                    <h2>${item.title}</h2>
                    <p>${item.pubDate}</p>
                    <p>${item.contentSnippet}</p>
                    <a href="${item.link}" target="_blank">Read more</a>
                </div>
            `).join('');

            newsFeedContainer.innerHTML = newsHTML;
        } else {
            newsFeedContainer.innerHTML = '<p>No news articles found.</p>';
        }
    } catch (error) {
        console.error('Error fetching and displaying the news feed:', error);
        newsFeedContainer.innerHTML = '<p>Error fetching news data.</p>';
    }
}

// Initialize the news feed when the page loads
window.addEventListener('load', displayNewsFeed);
