import Mousetrap from 'mousetrap';

Mousetrap.bind('?', function() { alert('keyboard shortcuts'); });

Mousetrap.bind(['ctrl+s', 'command+s'], function(event) {
    event.preventDefault();
    event.target.form.submit();
    alert();
});
