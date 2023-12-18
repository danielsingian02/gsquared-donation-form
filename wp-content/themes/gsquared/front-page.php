<?php
    get_header();
    $base_donation_amount = 413078 + calculateTotalDonations();
?>
<div class="hero text-gray-800 font-sans pb-12 bg-[url('/wp-content/uploads/2023/12/swish-bg-compressed.png')] bg-transparent bg-no-repeat bg-top">
    <!-- Header Section -->
    <div class="container mx-auto p-8 text-center text-white">
        <h1 class="text-[2.8125rem] mb-3 font-lora">Lorem Ipsum</h1>
        <p class="text-md mb-4 text-[1.125rem] font-light max-w-[815px] mx-auto">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et</p>
    </div>

    <!-- Donation Details -->
    <div class="mx-auto max-w-[1086px] mb-32 p-14 bg-white donation-details text-center rounded-2xl shadow-theme">
        
        <?php if (isset($_GET['donate']) && $_GET['donate'] === "success") : ?>
            <h2 class="text-[47px] leading-9 font-bold mb-2 text-teal">Success!</h2>
            <p class="text-2xl mb-8">Your donation has been processed successfully.</p>
            <div class="mt-8">
                <a href="/" class="bg-teal inline-block py-4 px-8 rounded font-bold text-white text-md visited:text-white hover:bg-teal-600 uppercase">Donate Again</a>
            </div>
        <?php else : ?>
        <p class="text-lg mb-4 font-bold font-lora">Lorem ipsum</p>
        <h2 class="text-[47px] leading-9 font-bold mb-2 text-teal" id="current-amount">$0</h2>
        <input type="hidden" value="<?= $base_donation_amount; ?>" id="hidden-current-amount">
        <p class="mb-8 text-2xl">of $4 million raised</p>
        <div class="max-w-[548px] mx-auto bg-slate-200 h-5 mb-8">
            <div class="bg-teal h-5 gs-progress-bar transition-all duration-700" style="width: 0%;"></div> <!-- Adjust width according to progress -->
        </div>

        <!-- Input Field -->
        <div class="flex mx-auto self-center max-w-[162px] relative">
            <label for="donation-amount" class="block absolute top-0 left-0 bottom-0 text-sm bg-[#EBEBEB] text-[17px] font-medium text-gray-900 p-3 dark:text-gray-300">$</label>
            <input type="text" id="donation-amount" name="donation_amount" class="p-2 pl-10 bg-transparent !shadow-none w-full !border !border-[#B8B8B8] relative" value="0.00" min="0" />
        </div>
        <p class="error-message hidden" data-error-name="donation_amount"></p>

        <div class="mx-auto  max-w-[495px] mt-4">
            <p class="text-[13px] font-light">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita</p>
        </div>

        <!-- Payment Form -->
        <div class="container mx-auto p-8 text-left">
            <!-- Form -->
            <form action="<?php echo admin_url('admin-post.php'); ?>" method="post" id="donation-form">
                <input type="hidden" name="action" value="donate">
                <input type="hidden" name="nonce_field" value="<?php echo wp_create_nonce('donate_nonce'); ?>">
                <input type="hidden" name="donation_amount">

                <h4 class="text-[1.125rem] font-semibold mb-4">Select payment method</h4>
                <div class="border-b-2 border-gray-200 mb-4"></div> <!-- Line separator -->

                <!-- Payment Method -->
                <div class="flex items-center text-[18px] gs-payment-method mb-10">
                    <div class="flex items-center mr-10">
                        <input type="radio" name="payment_method" id="paypal" value="paypal" class="mr-2" checked>
                        <label for="paypal" class="text-md font-semibold">Paypal</label>
                    </div>
                    <div class="flex items-center">
                        <input type="radio" name="payment_method" id="offline" value="offline" class="mr-2">
                        <label for="offline" class="text-md font-semibold">Offline donation</label>
                    </div>
                </div>

                <!-- Personal Info -->
                <h4 class="text-[1.125rem] font-semibold mb-4">Personal Info</h4>
                <div class="border-b-2 border-gray-200 mb-4"></div> <!-- Line separator -->
                <div class="flex flex-wrap -mx-3 mb-4">
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <input type="text" name="first_name" placeholder="First name*" required class="w-full px-4 h-12 border">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <input type="text" name="last_name" placeholder="Last name*" required class="w-full px-4 h-12 border">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3">
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <input type="email" name="email" placeholder="Email*" required class="w-full px-4 h-12 border">
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <input type="text" name="phone" placeholder="Phone*" required class="w-full px-4 h-12 border">
                    </div>
                </div>

                <!-- Donation Total -->
                <div class="mb-7 mt-6 text-center flex flex-col justify-center">
                    <div class="flex mx-auto items-center justify-center border max-w-full">
                        <span class="text-lg py-3 px-4 font-medium bg-slate-300">Donation total:</span>
                        <span class="text-lg py-3 px-8 donation-amount-display">$0.00</span>
                    </div>
                </div>

                <button type="submit" class="bg-teal text-white font-bold py-4 px-8 rounded hover:bg-blue-700 mx-auto flex">DONATE NOW</button>
            </form>
        </div>
        <?php endif; ?>
    </div>

    <!-- Vision Section -->
    <div class="">
        <div class="container mx-auto p-8">
            <div class="flex -mx-4 items-center gap-x-16 columns-2">
                <!-- Image Container -->
                <div class="w-full md:w-5/12">
                    <img src="/wp-content/uploads/2023/12/gsquared-vision-imag-scaled.jpg" alt="Vision" class="rounded shadow-md">
                </div>
                <!-- Content -->
                <div class="w-full md:w-7/12 p-16 relative">
                    <div class="icon-square-dot absolute top-0 left-0">
                        <?= get_template_part( 'template-parts/icons/icon', 'square-dots' ); ?>
                    </div>
                    <div class="icon-symbol-l icon-symbol-l--top absolute top-0 right-0 rotate-180">
                        <?= get_template_part( 'template-parts/icons/icon', 'symbol-l' ); ?>
                    </div>
                    <div class="icon-symbol-l icon-symbol-l--bottom absolute bottom-0 left-0">
                        <?= get_template_part( 'template-parts/icons/icon', 'symbol-l' ); ?>
                    </div>
                    <div class="relative">
                        <h3 class="text-[1.375rem] leading-7 mb-4 font-bold font-lora">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</h3>
                        <p class="text-[14px] font-light">With only 3 hospices / respite centres in Australia for children under the age of 18, Rio’s Legacy’s vision is to provide more facilities readily available for families going through the most difficult time in their lives, living with a child who has a terminal illness. On top of this, Rio’s Legacy will look to assist families who have a child in the intensive care unit at the Sydney Children’s Hospital and support children and young people who have been diagnosed with a terminal illness and their families at Bear Cottage.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    get_footer();