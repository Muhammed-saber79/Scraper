# Laravel Scraping Project

This is a Laravel-based web scraping project that extracts book data from multiple pages. It utilizes various packages such as Guzzle, Livewire, Symfony's DomCrawler, and more to facilitate the scraping process.

## Getting Started

Follow these instructions to set up and run the project on your local machine.

### Prerequisites

- PHP (= 8.2)
- Composer
- Node.js (>= 14)
- NPM or Yarn

### Clone the Repository

```bash
git clone https://github.com/Muhammed-saber79/Scraper.git
cd Scraper
```

### Install Dependencies

```bash
composer install
npm install
```

### Configure Environment
- Rename .env.example to .env:

    ```bash
    cp .env.example .env
    ```
- Configure your database settings in the .env file.

### Generate Application Key

```
php artisan key:generate
```

### Run Migrations

```
php artisan migrate
```

### Start the Development Server

```
php artisan serve
```

 Your application should now be accessible at http://localhost:8000.

### Running JavaScript
The project utilizes JavaScript for some functionalities. Make sure to install the required packages:

```
npm install
```
## Usage

The project has two main methods: `index` and `loadmore`.

- **index**: This method displays the homepage and initial book data.
- **loadmore**: This method dispatches a scraping job to gather more books.

### Access the Homepage

Open your web browser and navigate to [http://localhost:8000](http://localhost:8000).

### Load More Books

Click on the "Load More" button on the homepage to trigger the scraping process and gather more book data.

## Additional Notes

- The project uses Livewire for dynamic UI updates and Symfony's DomCrawler for web scraping.
- Book data is extracted from multiple pages, which might result in longer loading times.

## License

This project is licensed under the [Muhammed Saber's License](https://github.com/Muhammed-saber79).


