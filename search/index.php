<?php
    $pageTitle = __('Search Omeka ') . __('(%s total)', $total_results);
    $searchRecordTypes = get_search_record_types();
    echo head(array('title' => $pageTitle, 'bodyclass' => 'search'));
?>

<div class="container">
    <h1><?php echo __('Search Results'); ?> <?php echo search_filters(); ?></h1>
    <?php if ($total_results): ?>
        <?php echo pagination_links(); ?>
        <table id="search-results" class="table table-hover">
            <thead>
                <tr>
                    <th><?php echo __('Record Type');?></th>
                    <th><?php echo __('Collection');?></th>
                    <th><?php echo __('Title');?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (loop('search_texts') as $searchText): ?>
                    <?php 
                        $record = get_record_by_id($searchText['record_type'], $searchText['record_id']);
                        $collection = get_collection_for_item($record);
                        if ($collection) { $collectionTitle = metadata($collection, array('Dublin Core', 'Title')); }
                    ?>
                    <tr>
                        <td><?php echo $searchRecordTypes[$searchText['record_type']]; ?></td>
                        <td><?php if ($collection) { echo $collectionTitle; } ?></td>
                        <td><a href="<?php echo record_url($record, 'show'); ?>"><?php echo $searchText['title'] ? $searchText['title'] : '[Unknown]'; ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo pagination_links(); ?>
    <?php else: ?>
    <div id="no-results">
        <p><?php echo __('Your query returned no results.');?></p>
    </div>
    <?php endif; ?>
</div>
<?php echo foot(); ?>