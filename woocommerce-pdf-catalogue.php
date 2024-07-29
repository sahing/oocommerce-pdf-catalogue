<?php
/*
Plugin Name: WooCommerce PDF Catalogue
Description: Generates a PDF catalogue of WooCommerce products.
Version: 1.3
Author: Sahin Ahmed
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class WooCommercePDFCatalogue {

    public function __construct() {
        add_action('init', array($this, 'check_for_catalogue_request'));
    }

    public function check_for_catalogue_request() {
        if (isset($_GET['catalogue_id'])) {
            $catalogue_id = sanitize_text_field($_GET['catalogue_id']);
            try {
                $this->generate_html($catalogue_id);
            } catch (Exception $e) {
                wp_die('Error generating catalogue: ' . $e->getMessage());
            }
        }
    }

    private function generate_html($catalogue_id) {
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => -1,
        );

        if ($catalogue_id !== 'full') {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => intval($catalogue_id),
                ),
            );
        }

        $products = new WP_Query($args);

        if ($products->have_posts()) {
            ob_start(); // Start output buffering

            echo '<html><head><title>Product Catalogue</title>';
            echo '<link rel="stylesheet" type="text/css" href="' . plugin_dir_url(__FILE__) . 'catalogue-style.css" />';
            echo '</head><body>';
            echo '<div id="catalogue-container">';
            echo '<button id="downloadPdfTop" class="download-button">Download PDF</button>';
            echo '<div id="catalogue">';

            while ($products->have_posts()) {
                $products->the_post();
                global $product;

                echo '<div class="product-card">';
                if (has_post_thumbnail()) {
                    echo '<div class="product-image">';
                    echo '<img src="' . get_the_post_thumbnail_url(get_the_ID(), 'medium') . '" />';
                    echo '</div>';
                }

                echo '<div class="product-details">';
                echo '<h1 class="product-title">' . get_the_title() . '</h1>';
                echo '<div class="product-description">' . $product->get_short_description() . '</div>';
                echo '<div class="product-description">' . get_the_content() . '</div>';
                echo '<p class="product-price"><strong>Price: ' . wc_price($product->get_price()) . '</strong></p>';
                echo '</div>';
                echo '</div><hr>';
            }

            echo '</div>';
            echo '<button id="downloadPdfBottom" class="download-button">Download PDF</button>';
            echo '</div>';
            echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>';
            echo '<script>
                document.getElementById("downloadPdfTop").addEventListener("click", function() {
                    var element = document.getElementById("catalogue");
                    html2pdf(element, {
                        margin: 10,
                        filename: "catalogue.pdf",
                        image: { type: "jpeg", quality: 0.98 },
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: "mm", format: "a4", orientation: "portrait" }
                    });
                });
                document.getElementById("downloadPdfBottom").addEventListener("click", function() {
                    var element = document.getElementById("catalogue");
                    html2pdf(element, {
                        margin: 10,
                        filename: "catalogue.pdf",
                        image: { type: "jpeg", quality: 0.98 },
                        html2canvas: { scale: 2 },
                        jsPDF: { unit: "mm", format: "a4", orientation: "portrait" }
                    });
                });
            </script>';
            echo '</body></html>';

            ob_end_flush(); // End output buffering and output contents
            exit;
        } else {
            throw new Exception('No products found.');
        }
    }
}

new WooCommercePDFCatalogue();
