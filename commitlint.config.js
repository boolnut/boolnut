module.exports = {
	extends: ['@commitlint/config-conventional'],
	plugins: ['commitlint-plugin-function-rules'],
	rules: {
		'type-enum': [0],
		'type-empty': [0],
		'type-case': [0],
		'scope-case': [0],
		'subject-empty': [0],
		'subject-case': [0],
		'function-rules/type-enum': [
			2,
			'always',
			(parsed) => {
				const headerRegex = /^((BOOL|NUT|BUG|FIX)-(\d*)):\s(.*)$/;
				const isHeaderValid = parsed.header.match(headerRegex);
				if (isHeaderValid) {
					return [true];
				}
				return [
					false,
					`header must match format --> BOOL XXX: <message>, NUT XXX: <message>, BUG XXX: <message>, FIX XXX: <message>`,
				];
			},
		],
		/* eslint-enable @typescript-eslint/naming-convention */
	},
	ignores: [(commit) => commit.includes('package.json', 'composer.json')], // ignore if commit message is to update releases.json
};