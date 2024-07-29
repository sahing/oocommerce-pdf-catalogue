# oocommerce-pdf-catalogue
The WooCommerce PDF Catalogue plugin allows you to generate a PDF catalogue of your WooCommerce products. The catalogue can be generated for all products or for products within a specific category.
# WooCommerce PDF Catalogue

WooCommerce PDF Catalogue generates a PDF catalogue of WooCommerce products. This plugin can create a PDF of all products or products from a specific category when a specific URL parameter is passed.

## Installation

1. **Download the Plugin:**
   - Clone or download the plugin files.

2. **Upload the Plugin:**
   - Go to your WordPress Dashboard.
   - Navigate to `Plugins` > `Add New`.
   - Click `Upload Plugin`.
   - Choose the downloaded plugin zip file and click `Install Now`.

3. **Activate the Plugin:**
   - After the installation, click `Activate Plugin`.

## Usage

### Generate a PDF for All Products:

- Access the following URL in your browser:

http://yourwebsite.com/?catalogue_id=full

r
Copy code

### Generate a PDF for a Specific Category:

- Access the following URL in your browser:

http://yourwebsite.com/?catalogue_id=category_id

css
Copy code

Replace `category_id` with the actual WooCommerce category ID.

### Download PDF

- On the generated catalogue page, you will see "Download PDF" buttons at both the top and bottom of the page. Click either button to download the catalogue as a PDF.

## Notes

- Ensure that you have WooCommerce installed and activated on your WordPress site.
- The plugin enqueues a stylesheet to style the catalogue page, ensuring a professional look.
- This plugin uses the `html2pdf.js` library to convert the HTML catalogue to a PDF.

## Support

For any issues or questions, please contact the plugin author Sahin Ahmed.
