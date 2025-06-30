<?php
/**
 * The template for displaying comments
 *
 * @package Nordic_Tech
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h2 class="comments-title">
            <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(
                    esc_html__('One thought on &ldquo;%1$s&rdquo;', 'nordic-tech'),
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            } else {
                printf(
                    esc_html(_nx(
                        '%1$s thought on &ldquo;%2$s&rdquo;',
                        '%1$s thoughts on &ldquo;%2$s&rdquo;',
                        $comment_count,
                        'comments title',
                        'nordic-tech'
                    )),
                    number_format_i18n($comment_count), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    '<span>' . wp_kses_post(get_the_title()) . '</span>'
                );
            }
            ?>
        </h2>

        <ol class="comment-list">
            <?php
            wp_list_comments(
                array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 42,
                    'callback'    => 'nordic_tech_comment_callback',
                )
            );
            ?>
        </ol>

        <?php
        the_comments_navigation(
            array(
                'prev_text' => esc_html__('Older comments', 'nordic-tech'),
                'next_text' => esc_html__('Newer comments', 'nordic-tech'),
            )
        );
        ?>

        <?php if (!comments_open()) : ?>
            <p class="no-comments"><?php esc_html_e('Comments are closed.', 'nordic-tech'); ?></p>
        <?php endif; ?>

    <?php endif; ?>

    <?php
    comment_form(
        array(
            'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
            'title_reply_after'  => '</h2>',
            'class_form'         => 'comment-form',
            'class_submit'       => 'submit button',
        )
    );
    ?>

</div><!-- #comments -->