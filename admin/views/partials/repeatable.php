<?php
 
/**
 * Provides the 'Repeatable'.
 *
 * Provides repeatable field meta box view.
 * 
 * @since      0.3.0
 *
 * @package    RDS_Q_and_A
 * @subpackage RDS_Q_and_A/admin/partials
 */

/**
 * HTML View to show the repeatable field in the admin
 *
 * @since 0.4.0
 */
?>
<div class="inside">
    <div id="q-and-a-repeatables">
        <?php $q_and_a_s = get_post_meta( get_the_ID(), 'q-and-a-repeatables', true ); ?>
        <?php if ( ! empty( $q_and_a_s ) ) { $no=1;?>
		<?php $q_and_a['answer'] = ''; ?>
			<?php foreach ( $q_and_a_s as $q_and_a ) { ?>
				<h3>Q&amp;A <?php echo $no; ?></h3>
				<input type="text" name="question[]" value="<?php if ( ! empty($q_and_a['question'])) echo esc_attr( $q_and_a['question'] ); ?>" />
				<input type="text" name="answer[]" value="<?php if ( ! empty($q_and_a['answer'])) echo esc_attr( $q_and_a['answer'] ); ?>" />	
		<?php $no++;  } ?>
		
		<?php } ?>
	</div><!-- #q-and-a-repeatables -->    
	<p><input type="submit" id="q-and-a-add-repeatable" value="Add Question & Answer" class="button" />
</div>