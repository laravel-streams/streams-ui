<div>

    <form {!! $component->htmlAttributes([
        'action' => '/streams/ui/' . $component->id . '/login',
        'class' => 'flex flex-col justify-center w-72 mt-10',
    ]) !!}>
        <input class="mb-2" type="text" name="email" placeholder="Email">
        <input class="mb-2" type="password" name="password" placeholder="Password">
        <input type="submit" value="Login">
    </form>

</div>
