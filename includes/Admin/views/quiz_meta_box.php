
<div class="wrap">
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <label for="name"><?php esc_html( 'Options #1', 'quiz' ); ?></label>
                </th>
                <td>
                    <?php $options_1 = get_post_meta( $post->ID, 'quiz_options_1', true ) ? esc_html( get_post_meta( $post->ID, 'quiz_options_1', true ) ) : '' ; ?>
                    <input type="text" name="quiz_options_1" id="options1" class="regular-text" value="<?php echo $options_1; ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="address"><?php esc_html( 'Options #2', 'quiz' ); ?></label>
                </th>
                <td>
                    <?php $options_2 = get_post_meta( $post->ID, 'quiz_options_2', true ) ? esc_html( get_post_meta( $post->ID, 'quiz_options_2', true ) ) : '' ; ?>
                    <input type="text" name="quiz_options_2" id="options2" class="regular-text" value="<?php echo $options_2; ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="phone"><?php esc_html( 'Options #3', 'quiz' ); ?></label>
                </th>
                <td>
                    <?php $options_3 = get_post_meta( $post->ID, 'quiz_options_3', true ) ? esc_html( get_post_meta( $post->ID, 'quiz_options_3', true ) ) : '' ; ?>
                    <input type="text" name="quiz_options_3" id="options3" class="regular-text" value="<?php echo $options_3; ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="phone"><?php esc_html( 'Options #4', 'quiz' ); ?></label>
                </th>
                <td>
                    <?php $options_4 = get_post_meta( $post->ID, 'quiz_options_4', true ) ? esc_html( get_post_meta( $post->ID, 'quiz_options_4', true ) ) : '' ; ?>
                    <input type="text" name="quiz_options_4" id="options4" class="regular-text" value="<?php echo $options_4; ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="phone"><?php esc_html( 'Correct Answer', 'quiz' ); ?></label>
                </th>
                <td>
                    <?php $options_5 = get_post_meta( $post->ID, 'quiz_options_5', true ) ? esc_html( get_post_meta( $post->ID, 'quiz_options_5', true ) ) : '' ; ?>
                    <select name="quiz_options_5" id="quiz_correct" class="regular-text" >
                        <option value="<?php echo $options_5; ?>">Select correct options...</option>
                        <option value="1" <?php selected( $options_5, '1' ); ?> > Options #1 </option>
                        <option value="2" <?php selected( $options_5, '2' ); ?> > Options #2 </option>
                        <option value="3" <?php selected( $options_5, '3' ); ?> > Options #3 </option>
                        <option value="4" <?php selected( $options_5, '4' ); ?> > Options #4 </option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
</div>