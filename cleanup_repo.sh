#!/bin/bash
set -e

echo "=== Unstaging everything first (safety) ==="
git restore --staged .

echo "=== Removing corrupt duplicate file ==="
rm -f "app/Services/FinancialService.php\`"

echo "=== Moving scratch fix scripts to /scripts (out of app code, kept for history) ==="
mkdir -p scripts/archive
for f in add_faq_section.php add_process_timeline.php add_services_showcase.php \
  add_testimonials_grid.php add_trust_band.php bisect1.php bisect2.php bisect3.php \
  bisect4.php change_services_animation.php circle_reveal_step_cards.php \
  cleanup_3d_leftovers.php deal_step_cards.php escape_keyframes.php final_fix.php \
  fix_admin_nav.php fix_admin_nav2.php fix_dangling_script.php fix_home_scripts.php \
  fix_home_scripts2.php fix_leaflet_integrity.php fix_map.php fix_map_js_escaping.php \
  fix_map_livewire_ajax.php fix_marker_icons.php fix_script_directive.php \
  fix_script_placement.php fix_service_routes.php fix_services_individual_trigger.php \
  fix_step_card_opacity.php fix_style_block.php fix_trust_html.php \
  flip_step_cards_3d.php hero_overlay_reveal.php intensify_hero_parallax.php \
  merge_scripts.php move_leaflet_to_layout.php move_marquee_to_css.php \
  rebuild_tail.php remove_debug_badge.php revert_hero_overlay.php \
  revert_hero_parallax.php swap_logo_to_img.php swap_scripts.php \
  undo_trust_simple.php unpin_step_cards.php; do
  [ -f "$f" ] && mv "$f" scripts/archive/
done

echo "=== Removing stray artifacts ==="
rm -f newest oldest track_output.html

echo "=== Adding .gitignore entries ==="
touch .gitignore
grep -qxF 'reference/' .gitignore || echo 'reference/' >> .gitignore
grep -qxF 'scripts/archive/' .gitignore || echo 'scripts/archive/' >> .gitignore

echo "=== Done. Review with: git status ==="
