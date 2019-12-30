<?php
require_once __DIR__ . '/../lib/bootstrap.php';

settype($requestedCategoryID, "integer");

$maxCount = 25;

$offset = seekGET('o', 0);
$count = $maxCount;

RA_ReadCookieCredentials($user, $points, $truePoints, $unreadMessageCount, $permissions);

$numPostsFound = getRecentForumPosts($offset, $count, 90, $recentPostsData);

$errorCode = seekGET('e');

RenderHtmlStart();
RenderHtmlHead("Forum Recent Posts");
?>
<body>
<?php RenderTitleBar($user, $points, $truePoints, $unreadMessageCount, $errorCode, $permissions); ?>
<?php RenderToolbar($user, $permissions); ?>
<div id="mainpage">
    <div id='fullcontainer'>
        <div id="forums" class="left">
            <?php
            echo "<div class='navpath'>";
            echo "<a href='/forum.php'>Forum Index</a>";
            echo " &raquo; <b>Forum Post History</b></a>";
            echo "</div>";

            echo "<h3 class='longheader'>Forum Post History</h3>";

            //	Output all forums fetched, by category

            $lastCategory = "_init";

            $forumIter = 0;

            echo "<table style='table-layout:fixed;'>";

            echo "<thead>";
            echo "<tr>";
            echo "<th>Author</th>";
            echo "<th class='fullwidth'>Message</th>";
            echo "<th>Posted At</th>";
            echo "</tr>";
            echo "</thead>";

            echo "<tbody>";
            foreach ($recentPostsData as $topicPostData) {
                //var_dump( $topicPostData );

                $postMessage = $topicPostData['ShortMsg'];
                $postAuthor = $topicPostData['Author'];
                $forumTopicID = $topicPostData['ForumTopicID'];
                $forumTopicTitle = $topicPostData['ForumTopicTitle'];
                $forumCommentID = $topicPostData['CommentID'];
                $postTime = $topicPostData['PostedAt'];
                $nicePostTime = getNiceDate(strtotime($postTime));

                echo "<tr>";

                echo "<td>";
                echo GetUserAndTooltipDiv($postAuthor, true);
                echo "</td>";

                echo "<td class=''><a href='/viewtopic.php?t=$forumTopicID&c=$forumCommentID'>$forumTopicTitle</a><br>$postMessage...</td>";
                echo "<td class='smalldate'>$nicePostTime</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";

            echo "<div class='rightalign row'>";
            if ($offset > 0) {
                $prevOffset = $offset - $maxCount;
                echo "<a href='/forumposthistory.php?o=$prevOffset'>&lt; Previous $maxCount</a> - ";
            }
            if ($numPostsFound == $maxCount) {
                //	Max number fetched, i.e. there are more. Can goto next 25.
                $nextOffset = $offset + $maxCount;
                echo "<a href='/forumposthistory.php?o=$nextOffset'>Next $maxCount &gt;</a>";
            }
            echo "</div>";
            ?>
            <br>
        </div>
    </div>
</div>
<?php RenderFooter(); ?>
</body>
<?php RenderHtmlEnd(); ?>
