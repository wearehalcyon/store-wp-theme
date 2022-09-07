<?php
/**
 * Template name: Item Add
 */
    get_header();
    $curruser = get_current_user_id();

    $cats_args = array(
        'taxonomy'     => 'product_cat',
        'orderby'      => 'name',
        'show_count'   => false,
        'pad_counts'   => false,
        'hierarchical' => true,
        'title_li'     => null,
        'hide_empty'   => false,
        'parent'       => false
    );
    $all_categories = get_categories( $cats_args );
?>
    <div class="add_page">
        <main id="main" class="main site-main">
            <h1 class="page_title">Add New Item</h1>
            <form action="<?php echo get_the_permalink('') . '?page=add-item&action=send'; ?>" method="post" class="add_data item_data">
                <div class="desc">
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Title'); ?>
                            </div>
                        </h4>
                        <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>">
                        <input type="text" name="title" class="text_input title" placeholder="Ableton Progressive House Template (vol. 1)" required>
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Description'); ?>
                            </div>
                        </h4>
                        <textarea name="description" class="text_input description" cols="30" rows="5" placeholder="The description of the product greatly influences the sale. Try to describe your work in as much detail as possible, but at the same time, do not overload it with text." required></textarea>
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Category'); ?>
                            </div>
                        </h4>
                        <?php foreach ($all_categories as $all_category) : ?>
                            <?php if ($all_category->name == 'Audio' || $all_category->name == 'DAW Templates') : ?>
                                <label class="input_label">
                                    <input type="radio" name="category" data-target="<?php echo $all_category->slug . '-subcategory'; ?>" class="radio_input category" value="<?php echo $all_category->name; ?>" required><span><?php echo $all_category->name; ?></span>
                                </label>
                                <div class="subcategories <?php echo $all_category->slug . '-subcategory'; ?>">
                                    <?php
                                        $childterms = get_term_children($all_category->term_id, 'product_cat');
                                        foreach ($childterms as $childterm) :
                                    ?>
                                        <label class="input_label">
                                            <input type="radio" name="subcategory" class="radio_input subcategory" value="<?php echo get_term_by('id', $childterm, 'product_cat')->name; ?>" required><span><?php echo get_term_by('id', $childterm, 'product_cat')->name; ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Plugins Used'); ?><span>(Leave this field empty if this is Audio category or you not used any external plugins.)</span>
                            </div>
                        </h4>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Sylenth1 v2">Sylenth1 v2
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Sylenth1 v3">Sylenth1 v3
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Alchemy">Alchemy
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Nexus">Nexus
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Nexus 2">Nexus 2
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Nexus 3">Nexus 3
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Massive">Massive
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Massive X">Massive X
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="ANA 2">ANA 2
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Kick">Kick
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Kick 2">Kick 2
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Spire">Spire
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Spectrasonics Omnisphere">Spectrasonics Omnisphere
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Spectrasonics Atmosphere">Spectrasonics Atmosphere
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Spectrasonics Stylus RMX">Spectrasonics Stylus RMX
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Battery">Battery
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Kontakt">Kontakt
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Gladiator 2">Gladiator 2
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Valhalla DSP">Valhalla DSP
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Cableguys VST Bundle">Cableguys VST Bundle
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="FabFilter Bundle">FabFilter Bundle
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Waves 7">Waves 7
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Waves 8">Waves 8
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Waves 9">Waves 9
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Phaseplant">Phaseplant
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Serum">Serum
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Goat">Goat
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Vital">Vital
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Pigments 2">Pigments 2
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Avenger">Avenger
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Waves Audio Codex">Waves Audio Codex
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="4Front Piano">4Front Piano
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="4Front TruePianos">4Front TruePianos
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="A.O.M Invisible Limiter">A.O.M Invisible Limiter
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="ArtsAcoustic Reverb">ArtsAcoustic Reverb
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Bionic Delay">Bionic Delay
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Colossus">Colossus
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Discovery">Discovery
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Diva">Diva
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="East West Quantum Leap">East West Quantum Leap
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="East West Stormdrums">East West Stormdrums
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Glitch">Glitch
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="JP6K">JP6K
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="LFO Tool">LFO Tool
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Micro Tonic">Micro Tonic
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Native FM7">Native FM7
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Ohmicide">Ohmicide
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Ozone Bundle">Ozone Bundle
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="PSPaudioware">PSPaudioware
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Sausage Fattener">Sausage Fattener
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="SoftTube">SoftTube
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Sonalksis Bundle">Sonalksis Bundle
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Sonalksis TBK Stereo">Sonalksis TBK Stereo
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Stormbreakz">Stormbreakz
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="SPL Transient Designer">SPL Transient Designer
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="TAL-Flanger">TAL-Flanger
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="TP Basslane">TP Basslane
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Transient Shaper">Transient Shaper
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="V-Station">V-Station
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Vanguard">Vanguard
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Voxengo Sound Delay">Voxengo Sound Delay
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Xfer OTT">Xfer OTT
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Zebra2">Zebra2
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Hive">Hive
                        </label>
                        <label>
                            <input type="checkbox" name="plugins[]" value="Z3ta+">Z3ta+
                        </label>
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Additional Plugins'); ?><span>(Leave this field empty if this is Audio category or you not used any external plugins.)</span>
                            </div>
                        </h4>
                        <input type="text" name="additional_plugins" class="text_input price">
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Price'); ?><span style="display: block; margin: 0;">(IMPORTANT! We can offer this price if we consider your product to be of lower or higher quality. Notification will be sent to you in private messages.)</span>
                            </div>
                        </h4>
                        <input type="text" name="price" class="text_input price" placeholder="$100" required>
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Archive Link'); ?><span style="display: block; margin: 0;">(Please use sharing services like Dropbox, Zippyshare, WeTransfer etc... Also your archive should have main template or file, cover and readme text file.)</span>
                            </div>
                        </h4>
                        <input type="text" name="archive" class="text_input archive" placeholder="https://www.dropbox.com/h?preview=example-archive.zip" required>
                    </div>
                    <div class="formcontrol">
                        <h4>
                            <div class="add_data_half">
                                <?php esc_html_e('Confirmation'); ?>
                            </div>
                        </h4>
                        <label>
                            <input type="checkbox" name="confirmation" value="true" required>I agree with the terms of use of the service, and also confirm that this product does not violate other rights and is solely my intellectual property. I am fully responsible in case of violation of any rules or rights and laws.
                        </label>
                    </div>
                    <div class="formcontrol">
                        <button type="submit" class="button">Send</button>
                    </div>
                </div>
            </form>
        </main><!-- #main -->
    </div>
<?php
get_footer();