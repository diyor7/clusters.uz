<div class="form-group field-signupcompanyform-type">
    <label class="control-label" for="signupcompanyform-type"><?=t("Тип пользователя")?></label>
    <select id="signupcompanyform-type" class="form-control py-20 px-30 h-auto user_type" name="SignupCompanyForm[type]">
        <option value=""> - Выберите тип пользователя - </option>

        <?php foreach ($models as $index => $md): ?>
            <option value="<?=$index?>"><?=$md?></option>
        <?php endforeach; ?>

    </select>

    <p class="help-block help-block-error"></p>
</div>