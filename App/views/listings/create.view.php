<?= loadPartial("head") ?>
<?= loadPartial("navbar") ?>
<?= loadPartial("top-banner") ?>

<!-- Job Listings -->
<!-- Post a Job Form Box -->
<section class="flex justify-center items-center mt-20">
    <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
        <h2 class="text-4xl text-center font-bold mb-4">Create Job Listing</h2>
        <!-- <div class="message bg-red-100 p-3 my-3">This is an error message.</div>
        <div class="message bg-green-100 p-3 my-3">
          This is a success message.
        </div> -->
        <form method="POST" action="/listings">
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Job Info
            </h2>
            <div class="mb-4">
                <input type="text" name="title" placeholder="Job Title" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= isset($listing['title']) ? $listing['title'] : '' ?>" />
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['title']) ? $errors['title'] : '' ?>
                </div>
            </div>
            <div class="mb-4">
                <textarea name="description" placeholder="Job Description" class="w-full px-4 py-2 border rounded focus:outline-none"><?= isset($listing['description']) ? $listing['description'] : '' ?></textarea>
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['description']) ? $errors['description'] : '' ?>
                </div>
            </div>
            <div class="mb-4">
                <input type="text" name="salary" placeholder="Annual Salary" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= isset($listing['salary']) ? $listing['salary'] : '' ?>" />
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['salary']) ? $errors['salary'] : '' ?>
                </div>
            </div>
            <div class="mb-4">
                <input type="text" name="requirements" placeholder="Requirements" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= isset($listing['requirements']) ? $listing['requirements'] : '' ?>" />
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['requirements']) ? $errors['requirements'] : '' ?>
                </div>
            </div>
            <div class="mb-4">
                <input type="text" name="benefits" placeholder="Benefits" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= isset($listing['benefits']) ? $listing['benefits'] : '' ?>" />
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['benefits']) ? $errors['benefits'] : '' ?>
                </div>
            </div>
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
                Company Info & Location
            </h2>
            <div class="mb-4">
                <input type="text" name="company" placeholder="Company Name" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= isset($listing['company']) ? $listing['company'] : '' ?>" />
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['company']) ? $errors['company'] : '' ?>
                </div>
            </div>
            <div class="mb-4">
                <input type="text" name="address" placeholder="Address" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= isset($listing['address']) ? $listing['address'] : '' ?>" />
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['address']) ? $errors['address'] : '' ?>
                </div>
            </div>
            <div class="mb-4">
                <input type="text" name="city" placeholder="City" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= isset($listing['city']) ? $listing['city'] : '' ?>" />
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['city']) ? $errors['city'] : '' ?>
                </div>
            </div>
            <div class="mb-4">
                <input type="text" name="state" placeholder="State" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= isset($listing['state']) ? $listing['state'] : '' ?>" />
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['state']) ? $errors['state'] : '' ?>
                </div>
            </div>
            <div class="mb-4">
                <input type="text" name="phone" placeholder="Phone" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= isset($listing['phone']) ? $listing['phone'] : '' ?>" />
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['phone']) ? $errors['phone'] : '' ?>
                </div>
            </div>
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email Address For Applications" class="w-full px-4 py-2 border rounded focus:outline-none" value="<?= isset($listing['email']) ? $listing['email'] : '' ?>" />
                <div class="message bg-red-100 my-3 px-4 py-4">
                    <?= isset($errors['email']) ? $errors['email'] : '' ?>
                </div>
            </div>
            <button class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none">
                Save
            </button>
            <a href="/" class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none">
                Cancel
            </a>
        </form>
    </div>
</section>

<?= loadPartial("bottom-banner") ?>
<?= loadPartial("footer") ?>