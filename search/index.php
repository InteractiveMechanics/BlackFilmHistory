<?php
    $pageTitle = __('Search Omeka ') . __('(%s total)', $total_results);
    $searchRecordTypes = get_search_record_types();
    echo head(array('title' => $pageTitle, 'bodyclass' => 'search'));

    function search_results($str, $query, $numOfWordToAdd) {
        list($before, $after) = explode($query, $str);
    
        $before = rtrim($before);
        $after  = ltrim($after);
    
        $beforeArray = array_reverse(explode(" ", $before));
        $afterArray  = explode(" ", $after);
    
        $countBeforeArray = count($beforeArray);
        $countAfterArray  = count($afterArray);
    
        $beforeString = "";
        if($countBeforeArray < $numOfWordToAdd) {
            $beforeString = implode(' ', $beforeArray);
        }
        else {
            for($i = 0; $i < $numOfWordToAdd; $i++) {
                $beforeString = $beforeArray[$i] . ' ' . $beforeString; 
            }
        }
    
        $afterString = "";
        if($countAfterArray < $numOfWordToAdd) {
            $afterString = implode(' ', $afterArray);
        }
        else {
            for($i = 0; $i < $numOfWordToAdd; $i++) {
                $afterString = $afterString . $afterArray[$i] . ' '; 
            }
        }
    
        $string = $beforeString . ' <span class="text-primary">' . $query . '</span> ' . $afterString;
    
        return $string;
    }
?>

<div class="container">
    <h1><?php echo __('Search Results'); ?> <?php echo search_filters(); ?></h1>
    <?php if ($total_results): ?>
        <?php echo pagination_links(); ?>
        <table id="search-results" class="table table-hover">
            <thead>
                <tr>
                    <th><?php echo __('Collection');?></th>
                    <th><?php echo __('Title');?></th>
                    <th><?php echo __('Results');?></th>
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
                        <td><?php if ($collection) { echo $collectionTitle; } else { echo '<em class="text-muted">No collection</em>'; } ?></td>
                        <td><a href="<?php echo record_url($record, 'show'); ?>"><?php echo $searchText['title'] ? $searchText['title'] : '[Unknown]'; ?></a></td>
                        <td>
                            <?php
                                if ($collection) {
                                    $result = metadata($record, array('Item Type Metadata', 'Transcription'));
                                    $needle = preg_match('#<small>(.*?)</small>#', search_filters(), $matches);
                                    echo search_results($result, $matches[1], 8);
                                }
                            ?>
                        </td>
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