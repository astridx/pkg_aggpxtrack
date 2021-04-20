/**
 * @subpackage  Aggpxtrack
 *
 * @copyright   Copyright (C) 2017 Astrid Günther All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


(function ($, doc)
{
	'use strict';

	window.ImageManager = {

		/**
		 * Initialization
		 *
		 * @return  void
		 */
		initialize: function ()
		{
			var o = this.getUriObject(window.self.location.href),
				q = this.getQueryObject(o.query);

			this.editor = decodeURIComponent(q.e_name);

			// Setup image manager fields object
			this.fields = {
				'url': doc.getElementById("f_url"),
				'alt': doc.getElementById("f_alt"),
				'title': doc.getElementById("f_title"),
			};

			// Setup image listing objects
			this.folderlist = doc.getElementById('folderlist');
			this.frame = window.frames.imageframe;
			this.frameurl = this.frame.location.href;

			// Setup image listing frame
			$('#imageframe').on('load', function ()
			{
				ImageManager.onloadimageview();
			});

			// Setup folder up button
			$('#upbutton').off('click').on('click', function ()
			{
				ImageManager.upFolder();
			});
		},

		/**
		 * Called when the iframe is reloaded.
		 * Updates the form action with the correct folder.
		 * This should really be a hidden input rather than part of the action, no?
		 *
		 * @return  void
		 */
		onloadimageview: function ()
		{
			var folder = this.getImageFolder(),
				$form = $('#uploadForm'),
				portString = '', a, q;

			// Update the frame url
			this.frameurl = this.frame.location.href;
			this.setFolder(folder);

			a = this.getUriObject($form.attr('action'));
			q = this.getQueryObject(a.query);
			q.folder = folder;
			a.query = $.param(q);

			if (typeof (a.port) !== 'undefined' && a.port != 80)
			{
				portString = ':' + a.port;
			}

			$form.attr('action', a.scheme + '://' + a.domain + portString + a.path + '?' + a.query);
		},

		/**
		 * Get the current directory based on the query string of the iframe
		 *
		 * @return  string
		 */
		getImageFolder: function ()
		{
			return this.getQueryObject(this.frame.location.search.substring(1)).folder;
		},

		/**
		 * Called from outside when the 'OK' button (maybe 'insert' or 'submit', whatever) is clicked.
		 *
		 * @return  boolean  Always true
		 */
		onok: function ()
		{
			var tag = '',
				attr = [],
				url = this.fields.url.value,
				alt = this.fields.alt.value,
				title = this.fields.title.value;

			return true;
		},

		/**
		 * Called from outside when the directory selector is used.
		 *
		 * @param   string  folder  The folder to switch to
		 * @param   mixed   asset   Probably an integer or undefined, optional
		 * @param   mixed   author  Probably an integer or undefined, optional
		 *
		 * @return  void
		 */
		setFolder: function (folder, asset, author)
		{
			for (var i = 0, l = this.folderlist.length; i < l; i++)
			{
				if (folder == this.folderlist.options[i].value)
				{
					this.folderlist.selectedIndex = i;
					$(this.folderlist)
						.trigger('liszt:updated') // Mootools
						.trigger('chosen:updated'); // jQuery

					break;
				}
			}

			if (!!asset || !!author)
			{
				this.setFrameUrl(folder, asset, author);
			}
		},

		/**
		 * Move up one directory
		 *
		 * @return  void
		 */
		upFolder: function ()
		{
			var path = this.folderlist.value.split('/'),
				search;

			path.pop();
			search = path.join('/');

			this.setFolder(search);
			this.setFrameUrl(search);
		},

		/**
		 * Called from outside when a file is selected
		 *
		 * @param   string  file  Relative path to the file.
		 *
		 * @return  void
		 */
		populateFields: function (file)
		{
			if (file.toLowerCase().endsWith('gpx'))
				$("#f_url").val(image_base_path + file);
		},

		/**
		 * Not used.
		 * Should display messages. There are none.
		 *
		 * @param   string  text  The message text
		 *
		 * @return  void
		 */
		showMessage: function (text)
		{
			var $message = $('#message');

			$message.find('>:first-child').remove();
			$message.append(text);
			$('#messages').css('display', 'block');
		},

		/**
		 * Not used.
		 * Refreshes the iframe
		 *
		 * @return  void
		 */
		refreshFrame: function ()
		{
			this.frame.location.href = this.frameurl;
		},

		/**
		 * Sets the iframe url, loading a new page. Usually for changing directory.
		 *
		 * @param  string  folder  Relative path to directory
		 * @param  mixed   asset   Probably an integer or undefined, optional
		 * @param  mixed   author  Probably an integer or undefined, optional
		 */
		setFrameUrl: function (folder, asset, author)
		{
			var qs = {
				option: 'com_aggpxtrack',
				view: 'gpxtrackList',
				layout: doc.getElementById("f_layout").innerHTML,
				tmpl: 'component',
				asset: asset,
				author: author
			};

			// Don't run folder through params because / will end up double encoded.
			this.frameurl = 'index.php?' + $.param(qs) + '&folder=' + folder;
			this.frame.location.href = this.frameurl;
		},

		/**
		 * Convert a query string to an object
		 *
		 * @param   string  q  A query string (no leading ?)
		 *
		 * @return  object
		 */
		getQueryObject: function (q)
		{
			var rs = {};

			$.each((q || '').split(/[&;]/), function (key, val)
			{
				var keys = val.split('=');

				rs[keys[0]] = keys.length == 2 ? keys[1] : null;
			});

			return rs;
		},

		/**
		 * Break a url into its component parts
		 *
		 * @param   string  u  URL
		 *
		 * @return  object
		 */
		getUriObject: function (u)
		{
			var bitsAssociate = {},
				bits = u.match(/^(?:([^:\/?#.]+):)?(?:\/\/)?(([^:\/?#]*)(?::(\d*))?)((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[\?#]|$)))*\/?)?([^?#\/]*))?(?:\?([^#]*))?(?:#(.*))?/);

			$.each(['uri', 'scheme', 'authority', 'domain', 'port', 'path', 'directory', 'file', 'query', 'fragment'], function (key, index)
			{
				bitsAssociate[index] = (!!bits && !!bits[key]) ? bits[key] : '';
			});

			return bitsAssociate;
		}
	};

	$(function ()
	{
		window.ImageManager.initialize();
	});

}(jQuery, document));
