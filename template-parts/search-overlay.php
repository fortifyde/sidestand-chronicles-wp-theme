<div id="sc-search-overlay"
     class="sc-search-overlay"
     role="search"
     aria-label="<?php esc_attr_e( 'Site search', 'sidestand-chronicles' ); ?>">
    <form class="sc-search-overlay__form"
          method="get"
          action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input class="sc-search-overlay__input"
               type="search"
               name="s"
               placeholder="<?php esc_attr_e( 'Search the road…', 'sidestand-chronicles' ); ?>"
               autocomplete="off"
               aria-label="<?php esc_attr_e( 'Search', 'sidestand-chronicles' ); ?>">
        <button type="button"
                class="sc-search-overlay__close"
                aria-label="<?php esc_attr_e( 'Close search', 'sidestand-chronicles' ); ?>">
            &times;
        </button>
    </form>
</div>
