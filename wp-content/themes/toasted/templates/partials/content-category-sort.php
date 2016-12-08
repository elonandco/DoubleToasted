<?php
if (!isset($categorySortId)) {
    $categorySortId = 'dt-posts-order-by';
}

if (!isset($categorySortNonce)) {
    $categorySortNonce = 'dt-ajax-sort-posts';
}

if (!isset($categorySortCategory)) {
    $categorySortCategory = false;
}
?>

<div class="categories">
    <div class="drop">Categories<span>v</span></div>
    <div class="dropdown">
        <div class="tooltip"></div>
        <ul id="<?php echo $categorySortId; ?>"
            data-type="<?php echo $categorySortType; ?>"
            data-category="<?php echo $categorySortCategory; ?>"
            data-meta="<?php echo wp_create_nonce($categorySortNonce); ?>">
            <li data-orderby="newest" data-order="desc">Most Recent</li>
            <li data-orderby="popular">Most Popular</li>
            <li data-orderby="name" data-order="asc">Sort A to Z</li>
            <li data-orderby="name" data-order="desc">Sort Z to A</li>
        </ul>
    </div>
</div>